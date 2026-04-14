<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke tabel items (untuk mengambil nama barang)
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi ke tabel users (untuk mengambil nama staff yang menginput data)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}