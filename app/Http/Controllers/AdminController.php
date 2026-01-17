<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use App\Models\User; // Opsional jika butuh data user
use App\Notifications\StatusNotification;

class AdminController extends Controller
{
    // 1. Tampilkan Dashboard Admin (Berisi list barang & klaim pending)
    public function index()
    {
        // Ambil barang yang statusnya 'pending'
        $pendingItems = Item::where('status', 'pending')->latest()->get();
        
        // Ambil klaim yang statusnya 'pending'
        $pendingClaims = Claim::where('status', 'pending')->with(['item', 'user'])->latest()->get();

        // Ambil semua barang untuk riwayat admin
        $allItems = Item::latest()->paginate(10);

        return view('admin.dashboard', compact('pendingItems', 'pendingClaims', 'allItems'));
    }

    // 2. LOGIKA UPDATE STATUS BARANG (Approve/Reject Laporan)
    public function updateItemStatus(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        // Update Status: available / rejected
        $item->status = $request->status;
        $item->save();

        // --- KIRIM NOTIFIKASI KE PELAPOR ---
        $user = $item->user; 
        if ($user) {
            if ($request->status == 'available') {
                $user->notify(new StatusNotification(
                    'Laporan Disetujui',
                    "Laporan barang '{$item->title}' telah disetujui Admin dan kini tayang di dashboard.",
                    'success', 
                    route('user.history')
                ));
            } 
            elseif ($request->status == 'rejected') {
                $user->notify(new StatusNotification(
                    'Laporan Ditolak',
                    "Maaf, laporan barang '{$item->title}' ditolak. Silakan periksa kelengkapan data.",
                    'danger', 
                    route('user.history')
                ));
            }
        }

        return redirect()->back()->with('success', 'Status barang berhasil diperbarui!');
    }

    // 3. LOGIKA UPDATE STATUS KLAIM (Approve/Reject Klaim)
    public function updateClaimStatus(Request $request, $id)
    {
        $claim = Claim::with('item')->findOrFail($id);
        
        // Update Status: verified / rejected
        $claim->status = $request->status;
        $claim->save();

        // Jika klaim disetujui (verified), otomatis ubah status barang jadi 'returned' (dikembalikan)
        if ($request->status == 'verified') {
            $claim->item->update(['status' => 'returned']);
        }

        // --- KIRIM NOTIFIKASI KE PENGAJU KLAIM ---
        $user = $claim->user; 
        if ($user) {
            if ($request->status == 'verified') {
                $user->notify(new StatusNotification(
                    'Klaim Disetujui!',
                    "Selamat! Klaim Anda untuk '{$claim->item->title}' disetujui. Silakan ambil barang di Tata Usaha.",
                    'success',
                    route('user.history')
                ));
            } 
            elseif ($request->status == 'rejected') {
                $user->notify(new StatusNotification(
                    'Klaim Ditolak',
                    "Maaf, klaim Anda untuk '{$claim->item->title}' ditolak oleh Admin.",
                    'danger',
                    route('user.history')
                ));
            }
        }

        return redirect()->back()->with('success', 'Status klaim berhasil diperbarui!');
    }
}