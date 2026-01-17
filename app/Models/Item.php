<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Kolom mana saja yang boleh diisi oleh User
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'location',
        'date_event',
        'status',
        'image'
    ];

    // Relasi: Setiap Barang milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}