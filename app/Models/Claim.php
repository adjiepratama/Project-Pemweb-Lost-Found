<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'claimer_name',
        'claimer_nim',
        'claimer_email',
        'claimer_phone',
        'claim_description',
        'claim_proof',
        'status',
    ];

    // Relasi: Klaim ini untuk barang apa?
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi: Siapa yang mengajukan klaim?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}