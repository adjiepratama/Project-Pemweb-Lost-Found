<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporController extends Controller
{
    // ==========================================
    // 1. TAMPILKAN FORM LAPOR
    // ==========================================
    public function create()
    {
        return view('user.laporbarang'); // Pastikan nama file view sesuai
    }

    // ==========================================
    // 2. SIMPAN LAPORAN (STORE)
    // ==========================================
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title'       => 'required|max:255',
            'description' => 'required',
            'category'    => 'required',
            'date_event'  => 'required|date',
            'location'    => 'required',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:5048', // Wajib ada gambar
        ]);

        $imagePath = null;
        $imageHash = null;

        // 2. Proses Upload Gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // Simpan ke folder 'items' di storage public
            $filename = $file->store('items', 'public'); 
            $imagePath = $filename; 

            // 3. HITUNG HASH GAMBAR (Visual Fingerprint)
            // Ambil path fisik file yang baru diupload
            $fullPath = storage_path('app/public/' . $filename);
            
            // Panggil fungsi hashing
            $imageHash = $this->generateImageHash($fullPath);
        }

        // 4. Simpan ke Database
        Item::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'date_event'  => $request->date_event,
            'location'    => $request->location,
            'image'       => $imagePath, 
            'image_hash'  => $imageHash, // <--- PENTING: Simpan kode hash
            'status'      => 'pending', 
            'type'        => 'lost' 
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Laporan berhasil dikirim! Sistem sedang memverifikasi data Anda.');
    }

    // ==========================================
    // 3. FUNGSI UPDATE (Jika User Edit Laporan)
    // ==========================================
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

        // Jika user ganti gambar, kita harus update Hash-nya juga
        if ($request->hasFile('image')) {
            // Hapus gambar lama (Opsional, biar hemat storage)
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $file = $request->file('image');
            $filename = $file->store('items', 'public');
            $item->image = $filename;

            // Generate Hash Baru
            $fullPath = storage_path('app/public/' . $filename);
            $item->image_hash = $this->generateImageHash($fullPath);
        }

        $item->update([
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'date_event'  => $request->date_event,
            'location'    => $request->location,
            // Image & Hash sudah dihandle diatas
        ]);

        return redirect()->route('user.history')->with('success', 'Laporan berhasil diperbarui!');
    }

    // ==========================================
    // 4. FUNGSI HAPUS (Batalkan Laporan)
    // ==========================================
    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        
        if ($item->status == 'pending') {
            // Hapus file gambar
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            
            $item->delete();
            return redirect()->route('user.history')->with('success', 'Laporan berhasil dibatalkan.');
        }
        
        return redirect()->route('user.history')->withErrors('Laporan yang sudah diproses tidak bisa dibatalkan.');
    }

    // ==========================================
    // FUNGSI RAHASIA: GENERATE IMAGE HASH
    // (Digunakan untuk mengubah gambar jadi kode biner)
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
            default: return null; 
        }

        if (!$img) return null;

        // 1. Resize ke 8x8 pixel (Total 64 pixel) - Kecil agar cepat hitungnya
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

        // 4. Buat Hash String (1 jika > rata-rata, 0 jika < rata-rata)
        $hash = '';
        foreach ($pixels as $pixel) {
            $hash .= ($pixel >= $average) ? '1' : '0';
        }

        // Bersihkan memori server
        imagedestroy($img);
        imagedestroy($resized);

        return $hash; // Output contoh: "1010100011100..."
    }
}