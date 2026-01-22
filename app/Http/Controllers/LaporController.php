<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporController extends Controller
{
    public function create()
    {
        return view('user.laporbarang'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'category'    => 'required',
            'date_event'  => 'required|date',
            'location'    => 'required',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:5048', 
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
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'date_event'  => $request->date_event,
            'location'    => $request->location,
            'image'       => $imagePath, 
            'image_hash'  => $imageHash, 
            'status'      => 'pending', 
            'type'        => 'lost' 
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Laporan berhasil dikirim! Sistem sedang memverifikasi data Anda.');
    }

    public function update(Request $request, $id)
    {
        $item = Item::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'category'    => 'required',
            'date_event'  => 'required|date',
            'location'    => 'required',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $file = $request->file('image');
            $filename = $file->store('items', 'public');
            $item->image = $filename;

            $fullPath = storage_path('app/public/' . $filename);
            $item->image_hash = $this->generateImageHash($fullPath);
        }

        $item->update([
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'date_event'  => $request->date_event,
            'location'    => $request->location,
        ]);

        return redirect()->route('user.history')->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        
        if ($item->status == 'pending') {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            
            $item->delete();
            return redirect()->route('user.history')->with('success', 'Laporan berhasil dibatalkan.');
        }
        
        return redirect()->route('user.history')->withErrors('Laporan yang sudah diproses tidak bisa dibatalkan.');
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
}