<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserDashboardController extends Controller
{
    // ==========================================
    // 1. DASHBOARD UTAMA
    // ==========================================
    public function index(Request $request)
    {
        // Default: Ambil semua barang yang statusnya BUKAN pending
        $query = Item::where('status', '!=', 'pending');

        // --- FILTER 1: PENCARIAN ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        // --- FILTER 2: KATEGORI ---
        if ($request->filled('category') && $request->category != 'Semua') {
            $query->where('category', $request->category);
        }

        // --- FILTER 3: LOKASI ---
        if ($request->filled('location') && $request->location != 'Semua') {
            $query->where('location', $request->location);
        }

        // --- FILTER 4: STATUS ---
        if ($request->filled('status') && $request->status != 'Semua') {
            if ($request->status == 'Dikembalikan') {
                $query->where('status', 'returned');
            } elseif ($request->status == 'Ditemukan') {
                $query->where('status', 'available');
            } elseif ($request->status == 'Didonasikan') {
                $query->where('status', 'donated');
            }
        }

        // --- FILTER 5: TANGGAL ---
        if ($request->filled('date')) {
            $query->whereDate('date_event', $request->date);
        }

        $items = $query->latest()->get();

        return view('user.dashboard', compact('items'));
    }

    // ==========================================
    // 2. SEARCH BY IMAGE (VISUAL SEARCH)
    // ==========================================
    public function searchImage(Request $request)
    {
        $request->validate([
            'image_search' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        // 1. Proses Gambar Upload User
        $file = $request->file('image_search');
        $tempPath = $file->getRealPath(); // Ambil path sementara
        
        // 2. Hitung Hash dari gambar upload
        $searchHash = $this->generateImageHash($tempPath);

        if (!$searchHash) {
            return back()->withErrors(['image_search' => 'Gagal memproses gambar. Pastikan format valid.']);
        }

        // 3. Ambil semua barang dari DB yang punya hash dan status valid
        $dbItems = Item::whereNotNull('image_hash')
                        ->where('status', '!=', 'pending')
                        ->where('status', '!=', 'donated') // Opsional: jangan cari yang sudah didonasikan
                        ->get();

        $matchedItems = collect(); // Gunakan collection agar mudah dimanipulasi

        // 4. Bandingkan Hash (Levenshtein Distance)
        foreach ($dbItems as $item) {
            $dbHash = $item->image_hash;
            
            // Hitung perbedaan karakter antara dua hash
            $distance = levenshtein($searchHash, $dbHash);

            // Ambang batas (Threshold). 0 = Sama Persis. <= 15 = Mirip.
            if ($distance <= 15) {
                $matchedItems->push($item);
            }
        }

        // 5. Tampilkan Hasil
        if ($matchedItems->isEmpty()) {
            // Jika tidak ada yang mirip, tampilkan barang acak sebagai rekomendasi
            $items = Item::where('status', '!=', 'pending')->inRandomOrder()->take(4)->get();
            $message = "Tidak ditemukan barang yang mirip secara visual. Berikut rekomendasi lain:";
            $isSearch = true; 
        } else {
            $items = $matchedItems;
            $message = "Ditemukan " . $matchedItems->count() . " barang yang mirip dengan foto Anda.";
            $isSearch = true;
        }

        return view('user.dashboard', compact('items', 'isSearch'))->with('success', $message);
    }

    // ==========================================
    // FUNGSI BANTUAN: GENERATE IMAGE HASH (PHash)
    // ==========================================
    private function generateImageHash($imagePath)
    {
        if (!file_exists($imagePath)) return null;

        // Cek tipe gambar
        $type = exif_imagetype($imagePath);
        switch ($type) {
            case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($imagePath); break;
            case IMAGETYPE_PNG:  $img = imagecreatefrompng($imagePath); break;
            case IMAGETYPE_WEBP: $img = imagecreatefromwebp($imagePath); break;
            default: return null; // Format tidak didukung
        }

        if (!$img) return null;

        // 1. Resize ke 8x8 pixel (Total 64 pixel)
        $resized = imagecreatetruecolor(8, 8);
        imagecopyresampled($resized, $img, 0, 0, 0, 0, 8, 8, imagesx($img), imagesy($img));

        // 2. Ubah ke Grayscale (Hitam Putih)
        imagefilter($resized, IMG_FILTER_GRAYSCALE);

        // 3. Hitung Rata-rata Warna
        $totalColor = 0;
        $pixels = [];
        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $rgb = imagecolorat($resized, $x, $y);
                $gray = $rgb & 0xFF; // Ambil channel biru (karena grayscale R=G=B)
                $pixels[] = $gray;
                $totalColor += $gray;
            }
        }
        $average = $totalColor / 64;

        // 4. Buat Hash String (1 jika > rata-rata, 0 jika < rata-rata)
        $hash = '';
        foreach ($pixels as $pixel) {
            $hash .= ($pixel >= $average) ? '1' : '0';
        }

        // Bersihkan memori
        imagedestroy($img);
        imagedestroy($resized);

        return $hash;
    }

    // ==========================================
    // 3. HALAMAN FORM LAPOR
    // ==========================================
    public function showLapor()
    {
        return view('user.laporbarang');
    }

    // ==========================================
    // 4. PROSES SIMPAN LAPORAN (Updated dengan Hash)
    // ==========================================
    public function storeLapor(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'date_event' => 'required|date',
            'location' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        $imageHash = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Simpan file ke Storage (Disarankan) atau Public
            // Menggunakan store('items', 'public') agar pathnya konsisten
            $filename = $file->store('items', 'public'); 
            $imagePath = $filename; 

            // Hitung Hash Gambar untuk Database
            // Ambil full path fisik file di server
            $fullPath = storage_path('app/public/' . $filename);
            $imageHash = $this->generateImageHash($fullPath);
        }

        Item::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'date_event' => $request->date_event,
            'location' => $request->location,
            'image' => $imagePath, 
            'image_hash' => $imageHash, // Simpan Hash
            'status' => 'pending', 
            'type' => 'lost' 
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Laporan berhasil dikirim! Silakan cek menu Riwayat untuk melihat status.');
    }

    // ==========================================
    // 5. HALAMAN RIWAYAT (GABUNGAN LAPORAN & KLAIM)
    // ==========================================
    public function history()
    {
        $userId = Auth::id();

        // 1. AMBIL LAPORAN SAYA
        $reports = Item::where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->jenis_riwayat = 'laporan';
                return $item;
            });

        // 2. AMBIL KLAIM SAYA
        $claims = Claim::where('user_id', $userId)
            ->with('item') // Eager load relasi item
            ->latest()
            ->get()
            ->map(function ($claim) {
                return (object) [
                    'id' => $claim->id,
                    'item_id' => $claim->item_id,
                    'item' => $claim->item, // Masukkan objek item lengkap untuk diakses view
                    'title' => $claim->item->title ?? 'Barang Tidak Ditemukan',
                    'description' => "Klaim: " . $claim->claim_description,
                    'category' => $claim->item->category ?? '-',
                    'location' => $claim->item->location ?? '-',
                    'date_event' => $claim->created_at, // Tanggal klaim dibuat
                    'image' => $claim->item->image ?? null,
                    'status' => $claim->status,
                    'created_at' => $claim->created_at,
                    'updated_at' => $claim->updated_at,
                    'jenis_riwayat' => 'klaim',
                ];
            });

        // 3. GABUNGKAN
        $items = $reports->concat($claims)->sortByDesc('created_at');

        return view('user.riwayat', compact('items'));
    }

    // ==========================================
    // 6. UPDATE LAPORAN
    // ==========================================
    public function update(Request $request, $id)
    {
        $item = Item::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'date_event' => 'required|date',
            'location' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada (opsional tapi disarankan)
            // if ($item->image && Storage::disk('public')->exists($item->image)) {
            //     Storage::disk('public')->delete($item->image);
            // }

            $file = $request->file('image');
            $filename = $file->store('items', 'public');
            $item->image = $filename;

            // Update Hash Gambar Baru
            $fullPath = storage_path('app/public/' . $filename);
            $item->image_hash = $this->generateImageHash($fullPath);
        }

        $item->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'date_event' => $request->date_event,
            'location' => $request->location,
        ]);

        return redirect()->route('user.history')->with('success', 'Laporan berhasil diperbarui!');
    }

    // ==========================================
    // 7. DESTROY (Batalkan Laporan)
    // ==========================================
    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        if ($item->status == 'pending') {
            // Hapus file gambar jika perlu
            // Storage::disk('public')->delete($item->image);
            
            $item->delete();
            return redirect()->route('user.history')->with('success', 'Laporan berhasil dibatalkan.');
        }
        return redirect()->route('user.history')->withErrors('Laporan tidak bisa dibatalkan.');
    }

    // ==========================================
    // 8. DESTROY CLAIM (Batalkan Klaim)
    // ==========================================
    public function destroyClaim($id)
    {
        $claim = Claim::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($claim->status == 'pending') {
            $claim->delete();
            return redirect()->route('user.history')->with('success', 'Pengajuan klaim berhasil dibatalkan.');
        }

        return redirect()->route('user.history')->withErrors('Klaim yang sudah diproses tidak bisa dibatalkan.');
    }

    // ==========================================
    // 9. NOTIFIKASI (Tandai Dibaca)
    // ==========================================
    public function markAsRead()
    {
        if(auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        return redirect()->back();
    }
}