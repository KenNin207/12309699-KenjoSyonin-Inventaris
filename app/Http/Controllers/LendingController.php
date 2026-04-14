<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LendingController extends Controller
{
    public function index()
    {
        // Ambil riwayat peminjaman. with() digunakan untuk mengambil data relasi sekaligus.
        $lendings = Lending::with(['item', 'user'])->latest()->get();
        
        // Ambil barang yang stoknya lebih dari 0 untuk form peminjaman
        $items = Item::where('quantity', '>', 0)->get();

        return view('staff.lendings.index', compact('lendings', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'lending_date' => 'required|date',
        ]);

        // 1. Simpan data peminjaman
        Lending::create([
            'user_id' => Auth::id(), // ID staff yang sedang login
            'item_id' => $request->item_id,
            'lending_date' => $request->lending_date,
            'status' => 'borrowed',
        ]);

        // 2. Kurangi stok barang secara otomatis
        $item = Item::findOrFail($request->item_id);
        $item->decrement('quantity');

        return redirect()->back()->with('success', 'Barang berhasil dipinjam!');
    }

    public function returnItem($id)
    {
        $lending = Lending::findOrFail($id);

        // 1. Update status dan tanggal kembali
        $lending->update([
            'return_date' => now(), // Tanggal hari ini
            'status' => 'returned',
        ]);

        // 2. Tambahkan kembali stok barang
        $lending->item->increment('quantity');

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan!');
    }
}