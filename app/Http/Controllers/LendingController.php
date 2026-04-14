<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\LendingsExport;
use Maatwebsite\Excel\Facades\Excel;

class LendingController extends Controller
{
    public function index()
    {
        // Mengambil semua data lending beserta relasi tabel item dan user
        // latest() digunakan agar data terbaru muncul di paling atas
        $lendings = \App\Models\Lending::with(['item', 'user'])->latest()->get();

        return view('staff.lendings.index', compact('lendings'));
    }

    // 1. Menampilkan halaman form
    public function create()
    {
        // Ambil semua data barang untuk ditampilkan di pilihan dropdown
        $items = \App\Models\Item::all();
        return view('staff.lendings.create', compact('items'));
    }

    // 2. Memproses data dari form
    public function store(Request $request)
    {
        // Validasi input: perhatikan penggunaan .* karena data berupa array (banyak)
        $request->validate([
            'name' => 'required|string|max:255',
            'item_id' => 'required|array',
            'item_id.*' => 'required|exists:items,id',
            'total' => 'required|array',
            'total.*' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'staff_signature' => 'required',
            'borrower_signature' => 'required',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $itemsRequest = $request->item_id;
        $totalsRequest = $request->total;

        // Pengecekan Ketersediaan Stok
        foreach ($itemsRequest as $index => $itemId) {
            $item = \App\Models\Item::find($itemId);

            // Jika jumlah yang dipinjam lebih besar dari stok yang ada
            if ($totalsRequest[$index] > $item->quantity) {
                // Gagalkan proses dan kembalikan ke form dengan pesan error merah
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Total item more than available!');
            }
        }

        // Jika semua stok aman, simpan ke database
        foreach ($itemsRequest as $index => $itemId) {
            \App\Models\Lending::create([
                'item_id' => $itemId,
                'user_id' => auth()->id(),
                'borrower_name' => $request->name,
                'total' => $totalsRequest[$index],
                'description' => $request->description,
                'staff_signature' => $request->staff_signature,
                'borrower_signature' => $request->borrower_signature,
                'due_date' => $request->due_date,
                'status' => 'borrowed',
                'lending_date' => now(),
            ]);

        }

        // Kembalikan ke tabel lending dengan pesan sukses hijau
        return redirect()->route('lendings.index')->with('success', 'Success add new lending item!');
    }
    // Fungsi untuk memproses pengembalian barang
    public function returnItem($id)
    {
        $lending = \App\Models\Lending::findOrFail($id);

        $lending->update([
            'status' => 'returned',
            'return_date' => now()
        ]);

        return redirect()->back()->with('success', 'Success! Item has been returned.');
    }

    // Menghapus data riwayat peminjaman
    public function destroy($id)
    {
        // 1. Cari data berdasarkan ID
        $lending = \App\Models\Lending::findOrFail($id);

        // 2. Hapus data dari database
        $lending->delete();

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Success! Data has been deleted.');
    }

    // Fungsi mengekspor data ke Excel
    public function exportExcel(Request $request)
    {
        // Ambil data tanggal dari inputan form
        $start = $request->query('start_date');
        $end = $request->query('end_date');

        // Kalau ada tanggal, nama filenya jadi spesifik, kalau nggak ada jadi default
        $fileName = ($start && $end) ? "lendings-$start-to-$end.xlsx" : "lendings-all.xlsx";

        // Kirim tanggalnya ke file LendingsExport
        return Excel::download(new LendingsExport($start, $end), $fileName);
    }
}