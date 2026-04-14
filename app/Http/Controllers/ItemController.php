<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index()
    {
        // Tambahkan withCount('lendings') untuk menghitung jumlah peminjaman
        $items = Item::with('category')->withCount('lendings')->latest()->get();

        return view('admin.items.index', compact('items'));
    }
    // Fungsi untuk menampilkan halaman form tambah barang
    public function create()
    {
        // Ambil semua data kategori untuk ditampilkan di pilihan (dropdown)
        $categories = \App\Models\Category::all();

        return view('admin.items.create', compact('categories'));
    }

    // Fungsi untuk menyimpan data ke database
    public function store(Request $request)
    {
        // 1. Cek apakah data yang diinput user sudah benar dan tidak kosong
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'quantity' => 'required|numeric|min:1',
            'description' => 'nullable|string' // Boleh kosong
        ]);

        // 2. Simpan ke tabel items
        \App\Models\Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        // 3. Kembalikan ke halaman daftar barang
        return redirect()->route('items.index');
    }
    // Menampilkan form edit dengan data barang yang dipilih
    public function edit($id)
    {
        $item = \App\Models\Item::findOrFail($id);
        $categories = \App\Models\Category::all();

        return view('admin.items.edit', compact('item', 'categories'));
    }

    // Menyimpan perubahan data ke database
    public function update(Request $request, $id)
    {
        // Validasi inputan dari user
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'quantity' => 'required|numeric|min:1',
            'new_broke_item' => 'nullable|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        // Cari data barang yang mau diupdate
        $item = \App\Models\Item::findOrFail($id);

        // Jika form 'new_broke_item' diisi, ambil angkanya. Jika kosong, anggap 0.
        $tambahanRusak = $request->new_broke_item ? $request->new_broke_item : 0;

        // Total repair baru = repair lama + inputan baru
        $totalRepairBaru = $item->repair + $tambahanRusak;

        // 4. Simpan perubahan ke database
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'repair' => $totalRepairBaru,
            'description' => $request->description,
        ]);

        return redirect()->route('items.index');
    }

    // Menghapus data barang
    public function destroy($id)
    {
        $item = \App\Models\Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index');
    }

    // Menampilkan detail peminjaman untuk 1 barang spesifik
    public function showLendings($id)
    {
        // Ambil data item beserta data lendings-nya
        $item = \App\Models\Item::with('lendings')->findOrFail($id);

        return view('admin.items.lendings', compact('item'));
    }

    // Fungsi untuk memproses unduhan Excel
    public function exportExcel()
    {
        return Excel::download(new ItemsExport, 'items.xlsx');
    }

    // Menampilkan halaman Items khusus Staff
    public function staffIndex()
    {
        $items = \App\Models\Item::with('category')
            ->withCount(['lendings' => function ($query) {
                // Menghitung jumlah baris peminjaman yang belum dikembalikan
                $query->where('status', 'borrowed');
            }])
            ->withSum(['lendings' => function ($query) {
                // Menjumlahkan angka di kolom 'total' pada tabel lendings
                $query->where('status', 'borrowed');
            }], 'total')
            ->latest()
            ->get();

        return view('staff.items.index', compact('items'));
    }

}