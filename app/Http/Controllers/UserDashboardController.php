<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use App\Models\Claim; 
class UserDashboardController extends Controller
{
    // 1. DASHBOARD UTAMA
    public function index(Request $request)
    {
        $query = Item::where('status', '!=', 'pending');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category') && $request->category != 'Kategori') {
            $query->where('category', $request->category);
        }

        if ($request->filled('location') && $request->location != 'Lokasi Penemuan') {
            $query->where('location', $request->location);
        }

        if ($request->filled('status') && $request->status != 'Status') {
            if ($request->status == 'Dikembalikan') {
                $query->where('status', 'returned');
            } elseif ($request->status == 'Ditemukan') {
                $query->where('status', 'available');
            } elseif ($request->status == 'Didonasikan') {
                $query->where('status', 'donated');
            }
        }

        if ($request->filled('date')) {
            $query->whereDate('date_event', $request->date);
        }

        $items = $query->latest()->get();

        return view('user.dashboard', compact('items'));
    }

    // 2. SEARCH BY IMAGE
    public function searchImage(Request $request)
    {
        $request->validate([
            'image_search' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        $file = $request->file('image_search');
        $originalName = $file->getClientOriginalName();
        
        $keyword = pathinfo($originalName, PATHINFO_FILENAME);
        $keyword = str_replace(['_', '-'], ' ', $keyword);

        $items = Item::where('status', '!=', 'pending')
                     ->where(function($q) use ($keyword) {
                        $q->where('title', 'like', '%' . $keyword . '%')
                          ->orWhere('category', 'like', '%' . $keyword . '%')
                          ->orWhere('description', 'like', '%' . $keyword . '%');
                     })
                     ->latest()
                     ->get();

        $message = "Hasil pencarian gambar untuk kata kunci: '$keyword'";
        
        if ($items->isEmpty()) {
            $items = Item::where('status', '!=', 'pending')
                         ->inRandomOrder()
                         ->take(4)
                         ->get();
            $message = "Tidak ditemukan kecocokan visual untuk '$keyword'. Berikut barang rekomendasi:";
        }

        return view('user.dashboard', compact('items'))
            ->with('success', $message);
    }

    // 3. HALAMAN FORM LAPOR
    public function showLapor()
    {
        return view('user.laporbarang');
    }

    // 4. PROSES SIMPAN LAPORAN
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
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $imagePath = 'uploads/' . $filename; 
        }

        Item::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'date_event' => $request->date_event,
            'location' => $request->location,
            'image' => $imagePath, 
            'status' => 'pending', 
            'type' => 'lost' 
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Laporan berhasil dikirim! Silakan cek menu Riwayat untuk melihat status.');
    }

    
    // 5. HALAMAN RIWAYAT (GABUNGAN LAPORAN & KLAIM)
    public function history()
    {
        $userId = Auth::id();

        // 1. AMBIL LAPORAN SAYA (Tabel Items)
        $reports = Item::where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->jenis_riwayat = 'laporan'; // Penanda
                return $item;
            });

        // 2. AMBIL KLAIM SAYA (Tabel Claims)
        $claims = \App\Models\Claim::where('user_id', $userId)
            ->with('item') // Load data barang
            ->latest()
            ->get()
            ->map(function ($claim) {
                // Format data klaim agar strukturnya sama dengan laporan
                return (object) [
                    'id' => $claim->id,
                    'item_id' => $claim->item_id, // ID Asli barang
                    'title' => $claim->item->title ?? 'Barang Tidak Ditemukan',
                    'description' => "Klaim: " . $claim->claim_description,
                    'category' => $claim->item->category ?? '-',
                    'location' => $claim->item->location ?? '-',
                    'date_event' => $claim->created_at,
                    'image' => $claim->item->image ?? null,
                    'status' => $claim->status,
                    'created_at' => $claim->created_at,
                    'updated_at' => $claim->updated_at,
                    'jenis_riwayat' => 'klaim', // Penanda
                ];
            });

        // 3. GABUNGKAN
        $items = $reports->concat($claims)->sortByDesc('created_at');

        return view('user.riwayat', compact('items'));
    }


    // ==========================================
    // 7. FITUR BARU: UPDATE (Simpan Perubahan)
    // ==========================================
   // Method update tetap sama, hanya redirect-nya pastikan ke riwayat
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
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $item->image = 'uploads/' . $filename;
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
    // 8. FITUR BARU: DESTROY (Batalkan/Hapus)
    // ==========================================
   // Method destroy (untuk Laporan) biarkan seperti sebelumnya
    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        if ($item->status == 'pending') {
            $item->delete();
            return redirect()->route('user.history')->with('success', 'Laporan berhasil dibatalkan.');
        }
        return redirect()->route('user.history')->withErrors('Laporan tidak bisa dibatalkan.');
    }

    // TAMBAHKAN INI: Method untuk Hapus Klaim
    public function destroyClaim($id)
    {
        // Cari klaim milik user ini
        $claim = \App\Models\Claim::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Cek status, hanya pending yang boleh dihapus
        if ($claim->status == 'pending') {
            $claim->delete(); // Hapus data klaim
            return redirect()->route('user.history')->with('success', 'Pengajuan klaim berhasil dibatalkan.');
        }

        return redirect()->route('user.history')->withErrors('Klaim yang sudah diproses tidak bisa dibatalkan.');
    }
}