<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Menghitung total jenis barang di tabel items
        $totalBarang = Item::count();

        // Menghitung total transaksi peminjaman yang statusnya masih 'borrowed'
        $sedangDipinjam = Lending::where('status', 'borrowed')->count();

        $totalDamaged = \App\Models\Item::sum('repair');

        // Mengirim variabel ke halaman view
        return view('admin.dashboard', compact(
            'totalBarang',
            'sedangDipinjam',
            'totalDamaged', 
        ));
    }
}