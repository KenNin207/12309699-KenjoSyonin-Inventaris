<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = []; // Mengizinkan simpan data

    // Relasi untuk menghitung jumlah barang di kategori ini
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
