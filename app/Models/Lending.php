<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $guarded = []; // Izinkan simpan data

    // Relasi ke User (Siapa yang meminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Item (Barang apa yang dipinjam)
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}