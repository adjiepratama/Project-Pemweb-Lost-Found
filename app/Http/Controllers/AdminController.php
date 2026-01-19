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

class AdminController extends Controller
{
    public function index()
    {
        // --- 1. LOGIKA STATISTIK REAL-TIME ---
        $stats = [
            // Kartu 1: Total Barang
            'total_items' => Item::count(),
            // Hitung barang yang dibuat bulan ini
            'items_this_month' => Item::whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->count(),

            // Kartu 2: Laporan Masuk (Pending)
            'laporan_masuk' => Item::where('status', 'pending')->count(),
            // Hitung laporan yang masuk HARI INI
            'laporan_today' => Item::where('status', 'pending')
                                ->whereDate('created_at', Carbon::today())
                                ->count(),

            // Kartu 3: Klaim Pending
            'menunggu_verifikasi' => Claim::where('status', 'pending')->count(),
            // Hitung klaim yang masuk HARI INI
            'claims_today' => Claim::where('status', 'pending')
                                ->whereDate('created_at', Carbon::today())
                                ->count(),

            // Kartu 4: Barang Dikembalikan (Selesai)
            'barang_dikembalikan' => Item::where('status', 'returned')->count(),
            // Hitung barang yang dikembalikan BULAN INI
            'returned_this_month' => Item::where('status', 'returned')
                                        ->whereMonth('updated_at', Carbon::now()->month) // Cek tanggal update terakhir
                                        ->count(),
        ];

        // ... sisa kode query recentReports, recentClaims, newItems tetap sama ...
        $recentReports = Item::where('status', 'pending')->with('user')->latest()->take(3)->get();
        $recentClaims = Claim::where('status', 'pending')->with(['item', 'user'])->latest()->take(3)->get();
        $newItems = Item::latest()->take(4)->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'recentClaims', 'newItems'));
    }

    // --- LOGIKA UPDATE STATUS (Tetap Sama) ---
    // Update Status Barang (Untuk Tombol Review/Validasi)
    public function updateItemStatus(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        // Hanya update statusnya saja
        $item->status = $request->status;
        $item->save();

        // Pesan sukses sesuai aksi
        $message = $request->status == 'available' ? 'Laporan berhasil disetujui!' : 'Laporan berhasil ditolak.';

        return redirect()->back()->with('success', $message);
    }
    
    // Fungsi Update Status (Jika belum ada/perlu disesuaikan)
    public function updateClaimStatus(Request $request, $id)
    {
        $claim = Claim::findOrFail($id);
        
        // Update Status
        $claim->status = $request->status;
        
        // Simpan Catatan / Alasan Penolakan (Pastikan kolom ini ada di tabel claims)
        // $table->text('admin_note')->nullable(); -> Tambahkan di migration jika belum ada
        if ($request->has('note')) {
            $claim->admin_note = $request->note;
        }
        
        $claim->save();

        // Jika diverifikasi, ubah status barang jadi 'claimed' atau 'returned'
        if ($request->status == 'verified') {
            $claim->item->update(['status' => 'returned']); // Barang sudah dikembalikan
        } elseif ($request->status == 'rejected') {
            $claim->item->update(['status' => 'available']); // Barang tersedia lagi
        }

        return redirect()->back()->with('success', 'Status klaim berhasil diperbarui!');
    }

    public function kelolaBarang(Request $request)
    {
        // 1. Query Dasar
        $query = Item::query();

        // 2. Filter Pencarian
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // 3. Filter Kategori
        if ($request->filled('category') && $request->category != 'Semua') {
            $query->where('category', $request->category);
        }

        // 4. Filter Status
        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // Ambil Data (Pagination 10 per halaman)
        $items = $query->latest()->paginate(10);

        // 5. Hitung Barang Siap Donasi (> 90 hari & belum diklaim/kembali)
        // Sesuai referensi gambar
        $donationReadyCount = Item::where('created_at', '<=', Carbon::now()->subDays(90))
            ->whereIn('status', ['available', 'pending'])
            ->count();

        return view('admin.kelola_barang', compact('items', 'donationReadyCount'));
    }

    // SIMPAN BARANG BARU
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
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'date_event' => $request->date_found, // Pastikan ada kolom ini di DB atau gunakan created_at
            'image' => $path,
            'status' => 'available', // Default tersedia
            'user_id' => auth()->id() // Admin yang input
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    // UPDATE BARANG
    public function updateBarang(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        $data = $request->except(['image', '_token', '_method']);
        
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image) Storage::disk('public')->delete($item->image);
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($data);

        return redirect()->back()->with('success', 'Data barang berhasil diperbarui!');
    }

    // HAPUS BARANG
    public function destroyBarang($id)
    {
        $item = Item::findOrFail($id);
        if ($item->image_path) Storage::disk('public')->delete($item->image_path);
        $item->delete();
        
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    public function laporanTemuan(Request $request)
    {
        // 1. Query Dasar (Ambil data item beserta user pelapornya)
        $query = Item::with('user');

        // 2. Filter Pencarian (Judul Barang atau Nama Pelapor)
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

        // 3. Filter Status (Mapping dari Tombol UI ke Database)
        // pending -> pending
        // disetujui -> available
        // ditolak -> rejected
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

        // Ambil Data
        $laporan = $query->latest()->paginate(10);

        // 4. Hitung Statistik untuk Kartu Atas
        $stats = [
            'total'    => Item::count(),
            'pending'  => Item::where('status', 'pending')->count(),
            'approved' => Item::where('status', 'available')->count(),
            'rejected' => Item::where('status', 'rejected')->count(),
        ];

        return view('admin.laporan_temuan', compact('laporan', 'stats'));
    }

    public function verifikasiKlaim(Request $request)
    {
        // 1. Query Dasar (Ambil data klaim beserta barang & user pengklaim)
        $query = Claim::with(['item', 'user']);

        // 2. Filter Pencarian (Nama Barang, Nama Pengklaim, NIM, atau ID Klaim)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Cari berdasarkan ID Klaim (misal CLM-001)
                $q->where('id', 'like', "%{$search}%")
                  // Cari berdasarkan Nama Barang
                  ->orWhereHas('item', function($i) use ($search) {
                      $i->where('title', 'like', "%{$search}%");
                  })
                  // Cari berdasarkan User
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('no_unik', 'like', "%{$search}%");
                  });
            });
        }

        // 3. Filter Status
        if ($request->has('status') && $request->status != 'semua') {
            // Mapping status UI ke Database
            $statusMap = [
                'menunggu' => 'pending',
                'verifikasi' => 'verification', // Jika ada status intermediate
                'disetujui' => 'verified',
                'ditolak' => 'rejected'
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        // Ambil Data
        $claims = $query->latest()->paginate(10);

        // 4. Hitung Statistik untuk Kartu Atas
        $stats = [
            'pending' => Claim::where('status', 'pending')->count(),
            'verification' => Claim::where('status', 'verification')->count(), // Opsional
            'approved_month' => Claim::where('status', 'verified')
                                     ->whereMonth('updated_at', now()->month)
                                     ->count(),
        ];

        return view('admin.verifikasi_klaim', compact('claims', 'stats'));
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        // 1. Validasi input dengan nama 'profile_photo'
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // validasi lain...
        ]);

        $user = auth()->user();

        // 2. Cek apakah ada file yang diupload dengan nama 'profile_photo'
        if ($request->hasFile('profile_photo')) {
            
            // Hapus foto lama jika ada (Optional, agar storage tidak penuh)
            // if ($user->profile_photo) { 
            //     Storage::disk('public')->delete($user->profile_photo); 
            // }
            
            // Simpan file
            $path = $request->file('profile_photo')->store('profiles', 'public');
            
            // 3. Simpan path ke kolom database 'profile_photo'
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
}