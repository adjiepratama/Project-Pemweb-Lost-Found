<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::where('status', '!=', 'pending');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category') && $request->category != 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->filled('location') && $request->location != 'Semua') {
            $query->where('location', $request->location);
        }

        if ($request->filled('status') && $request->status != 'Semua') {
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

    public function searchImage(Request $request)
    {
        $request->validate([
            'image_search' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        $file = $request->file('image_search');
        $tempPath = $file->getRealPath(); 
        
        $searchHash = $this->generateImageHash($tempPath);

        if (!$searchHash) {
            return back()->withErrors(['image_search' => 'Gagal memproses gambar. Pastikan format valid.']);
        }

        $dbItems = Item::whereNotNull('image_hash')
                        ->where('status', '!=', 'pending')
                        ->where('status', '!=', 'donated') 
                        ->get();

        $matchedItems = collect(); 

        foreach ($dbItems as $item) {
            $dbHash = $item->image_hash;
            
            $distance = levenshtein($searchHash, $dbHash);

            if ($distance <= 15) {
                $matchedItems->push($item);
            }
        }

        if ($matchedItems->isEmpty()) {
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

        $resized = imagecreatetruecolor(8, 8);
        imagecopyresampled($resized, $img, 0, 0, 0, 0, 8, 8, imagesx($img), imagesy($img));

        imagefilter($resized, IMG_FILTER_GRAYSCALE);

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

        $hash = '';
        foreach ($pixels as $pixel) {
            $hash .= ($pixel >= $average) ? '1' : '0';
        }

        imagedestroy($img);
        imagedestroy($resized);

        return $hash;
    }

    public function showLapor()
    {
        return view('user.laporbarang');
    }

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
            
            $filename = $file->store('items', 'public'); 
            $imagePath = $filename; 

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
            'image_hash' => $imageHash, 
            'status' => 'pending', 
            'type' => 'lost' 
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Laporan berhasil dikirim! Silakan cek menu Riwayat untuk melihat status.');
    }

    public function history()
    {
        $userId = Auth::id();

        $reports = Item::where('user_id', $userId)
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->jenis_riwayat = 'laporan';
                return $item;
            });

        $claims = Claim::where('user_id', $userId)
            ->with('item') 
            ->latest()
            ->get()
            ->map(function ($claim) {
                return (object) [
                    'id' => $claim->id,
                    'item_id' => $claim->item_id,
                    'item' => $claim->item,
                    'title' => $claim->item->title ?? 'Barang Tidak Ditemukan',
                    'description' => "Klaim: " . $claim->claim_description,
                    'category' => $claim->item->category ?? '-',
                    'location' => $claim->item->location ?? '-',
                    'date_event' => $claim->created_at, 
                    'image' => $claim->item->image ?? null,
                    'status' => $claim->status,
                    'created_at' => $claim->created_at,
                    'updated_at' => $claim->updated_at,
                    'jenis_riwayat' => 'klaim',
                ];
            });

        $items = $reports->concat($claims)->sortByDesc('created_at');

        return view('user.riwayat', compact('items'));
    }

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
            $filename = $file->store('items', 'public');
            $item->image = $filename;
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

    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        if ($item->status == 'pending') {
            $item->delete();
            return redirect()->route('user.history')->with('success', 'Laporan berhasil dibatalkan.');
        }
        return redirect()->route('user.history')->withErrors('Laporan tidak bisa dibatalkan.');
    }

    public function destroyClaim($id)
    {
        $claim = Claim::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        if ($claim->status == 'pending') {
            $claim->delete();
            return redirect()->route('user.history')->with('success', 'Pengajuan klaim berhasil dibatalkan.');
        }

        return redirect()->route('user.history')->withErrors('Klaim yang sudah diproses tidak bisa dibatalkan.');
    }

    public function markAsRead()
    {
        if(auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        return redirect()->back();
    }
}