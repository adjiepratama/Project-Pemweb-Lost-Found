<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str; 
use App\Notifications\StatusNotification; 

class AdminController extends Controller
{
    public function index()
    {
        // --- 1. LOGIKA STATISTIK REAL-TIME ---
        $stats = [
            'total_items' => Item::count(),
            'items_this_month' => Item::whereMonth('created_at', Carbon::now()->month)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->count(),

            'laporan_masuk' => Item::where('status', 'pending')->count(),
            'laporan_today' => Item::where('status', 'pending')
                                    ->whereDate('created_at', Carbon::today())
                                    ->count(),

            'menunggu_verifikasi' => Claim::where('status', 'pending')->count(),
            'claims_today' => Claim::where('status', 'pending')
                                    ->whereDate('created_at', Carbon::today())
                                    ->count(),

            'barang_dikembalikan' => Item::where('status', 'returned')->count(),
            'returned_this_month' => Item::where('status', 'returned')
                                        ->whereMonth('updated_at', Carbon::now()->month)
                                        ->count(),
        ];

        $recentReports = Item::where('status', 'pending')->with('user')->latest()->take(3)->get();
        $recentClaims = Claim::where('status', 'pending')->with(['item', 'user'])->latest()->take(3)->get();
        $newItems = Item::latest()->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'recentClaims', 'newItems'));
    }

    // --- UPDATE STATUS BARANG (Review Laporan) + NOTIFIKASI ---
    public function updateItemStatus(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        $item->status = $request->status;
        $item->save();

        // --- KIRIM NOTIFIKASI KE USER PELAPOR ---
        if ($item->user) {
            if ($request->status == 'available') {
                $item->user->notify(new StatusNotification(
                    'Laporan Disetujui',
                    "Laporan Anda '{$item->title}' telah disetujui dan kini tayang di publik.",
                    'success',
                    route('user.history')
                ));
            } elseif ($request->status == 'rejected') {
                $item->user->notify(new StatusNotification(
                    'Laporan Ditolak',
                    "Maaf, laporan '{$item->title}' ditolak. Silakan periksa kembali data Anda.",
                    'danger',
                    route('user.history')
                ));
            }
        }

        $message = $request->status == 'available' ? 'Laporan berhasil disetujui!' : 'Laporan berhasil ditolak.';
        return redirect()->back()->with('success', $message);
    }
    
    // --- UPDATE STATUS KLAIM (Verifikasi) + NOTIFIKASI ---
    public function updateClaimStatus(Request $request, $id)
    {
        $claim = Claim::findOrFail($id);
        
        $claim->status = $request->status;
        
        if ($request->has('note')) {
            $claim->admin_note = $request->note;
        }
        $claim->save();

        if ($request->status == 'verified') {
            $claim->item->update(['status' => 'returned']); 
        } elseif ($request->status == 'rejected') {
            $claim->item->update(['status' => 'available']); 
        }

        // --- KIRIM NOTIFIKASI KE USER PENGKLAIM ---
        if ($claim->user) {
            if ($request->status == 'verified') {
                $claim->user->notify(new StatusNotification(
                    'Klaim Diterima! 🎉',
                    "Selamat! Klaim untuk '{$claim->item->title}' telah disetujui. Silakan ambil barang Anda.",
                    'success',
                    route('user.history')
                ));
            } elseif ($request->status == 'rejected') {
                $claim->user->notify(new StatusNotification(
                    'Klaim Ditolak',
                    "Maaf, klaim '{$claim->item->title}' ditolak. Alasan: " . ($request->note ?? 'Data tidak sesuai.'),
                    'danger',
                    route('user.history')
                ));
            }
        }

        return redirect()->back()->with('success', 'Status klaim berhasil diperbarui!');
    }

    // --- Kelola Barang (Search, Filter, & Auto-Donasi) ---
    public function kelolaBarang(Request $request)
    {
        // --- 1. FITUR OTOMATIS: AUTO DONASI > 180 HARI ---
        Item::whereIn('status', ['available', 'pending'])
            ->where('created_at', '<=', Carbon::now()->subDays(180))
            ->update(['status' => 'donated']);
        // --------------------------------------------------

        $query = Item::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category != 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        $items = $query->latest()->paginate(10);

        // Hitung total barang yang sudah didonasikan
        $donationReadyCount = Item::where('status', 'donated')->count();

        return view('admin.kelola_barang', compact('items', 'donationReadyCount'));
    }

    // --- Store Barang Baru (UPDATED WITH HASHING) ---
    public function storeBarang(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required',
            'location' => 'required',
            'date_found' => 'required|date',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = null;
        $imageHash = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            
            // --- HITUNG HASH ---
            $fullPath = storage_path('app/public/' . $path);
            $imageHash = $this->generateImageHash($fullPath);
        }

        Item::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'date_event' => $request->date_found,
            'image' => $path,
            'image_hash' => $imageHash, // Simpan Hash
            'status' => 'available', 
            'user_id' => auth()->id() 
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    // --- Update Barang (UPDATED WITH HASHING) ---
    public function updateBarang(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        $data = $request->except(['image', '_token', '_method']);
        
        if ($request->hasFile('image')) {
            if ($item->image) Storage::disk('public')->delete($item->image);
            
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;

            // --- HITUNG HASH BARU ---
            $fullPath = storage_path('app/public/' . $path);
            $data['image_hash'] = $this->generateImageHash($fullPath);
        }

        $item->update($data);

        return redirect()->back()->with('success', 'Data barang berhasil diperbarui!');
    }

    // --- Hapus Barang ---
    public function destroyBarang($id)
    {
        $item = Item::findOrFail($id);
        if ($item->image) Storage::disk('public')->delete($item->image);
        $item->delete();
        
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    // --- Laporan Temuan (Search & Filter) ---
    public function laporanTemuan(Request $request)
    {
        $query = Item::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('no_unik', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && $request->status != 'semua') {
            $statusMap = [
                'pending'   => 'pending',
                'disetujui' => 'available',
                'ditolak'   => 'rejected'
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        $laporan = $query->latest()->paginate(10);

        $stats = [
            'total'    => Item::count(),
            'pending'  => Item::where('status', 'pending')->count(),
            'approved' => Item::where('status', 'available')->count(),
            'rejected' => Item::where('status', 'rejected')->count(),
        ];

        return view('admin.laporan_temuan', compact('laporan', 'stats'));
    }

    // --- Verifikasi Klaim (Search & Filter) ---
    public function verifikasiKlaim(Request $request)
    {
        $query = Claim::with(['item', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('item', function($i) use ($search) {
                      $i->where('title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('no_unik', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && $request->status != 'semua') {
            $statusMap = [
                'menunggu' => 'pending',
                'disetujui' => 'verified',
                'ditolak' => 'rejected'
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        $claims = $query->latest()->paginate(10);

        $stats = [
            'pending' => Claim::where('status', 'pending')->count(),
            'verification' => Claim::where('status', 'verification')->count(),
            'approved_month' => Claim::where('status', 'verified')
                                     ->whereMonth('updated_at', now()->month)
                                     ->count(),
        ];

        return view('admin.verifikasi_klaim', compact('claims', 'stats'));
    }

    // --- Profil Admin ---
    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    // ==========================================
    // FUNGSI BANTUAN: GENERATE IMAGE HASH (PHash)
    // ==========================================
    private function generateImageHash($imagePath)
    {
        if (!file_exists($imagePath)) return null;

        $type = exif_imagetype($imagePath);
        switch ($type) {
            case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($imagePath); break;
            case IMAGETYPE_PNG:  $img = imagecreatefrompng($imagePath); break;
            case IMAGETYPE_WEBP: $img = imagecreatefromwebp($imagePath); break;
            default: return null; 
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
                $gray = $rgb & 0xFF; 
                $pixels[] = $gray;
                $totalColor += $gray;
            }
        }
        $average = $totalColor / 64;

        // 4. Buat Hash String
        $hash = '';
        foreach ($pixels as $pixel) {
            $hash .= ($pixel >= $average) ? '1' : '0';
        }

        imagedestroy($img);
        imagedestroy($resized);

        return $hash;
    }
}