<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserProfileController extends Controller
{
    // 1. Tampilkan Halaman Profile
    public function index()
    {
        return view('user.profile');
    }

    // 2. Update Foto Profil Saja
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        // Validasi HANYA Foto
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                unlink(public_path($user->profile_photo)); 
            }

            // Simpan foto baru
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            
            // Simpan path ke database
            $user->profile_photo = 'uploads/profiles/' . $filename;
            $user->save();
            
            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->back()->withErrors('Silakan pilih foto terlebih dahulu.');
    }

    // 3. Update Password (INI YANG TADI HILANG)
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed', 
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diubah!');
    }
}