<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; // Panggil Model Item
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Nanti di sini kita bisa ambil data dari database
        // $items = Item::all(); 
        
        // Untuk sekarang, kita tampilkan view yang sudah kamu buat tadi
        return view('user.dashboard');
    }
}