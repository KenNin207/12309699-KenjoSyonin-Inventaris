<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemsExport implements FromCollection, WithHeadings, WithMapping
{
    // 1. Mengambil data dari database
    public function collection()
    {
        // Gunakan with('category') agar nama kategori bisa dipanggil
        return Item::with('category')->get();
    }

    // 2. Membuat baris pertama (Header/Judul Kolom) di Excel
    public function headings(): array
    {
        return [
            'Category',
            'Name Item',
            'Total',
            'Repair Total',
            'Last Updated'
        ];
    }

    // 3. Mengatur format isi data per baris
    public function map($item): array
    {
        return [
            // Ambil nama kategori, jika kosong tulis '-'
            $item->category->name ?? '-', 
            
            $item->name,
            
            $item->quantity,
            
            // Jika repair 0, ubah jadi '-', jika tidak tampilkan angkanya
            $item->repair == 0 ? '-' : $item->repair,
            
            // Format tanggal menjadi 'Jan 14, 2023' (M = singkatan bulan, d = tanggal, Y = tahun)
            $item->updated_at ? $item->updated_at->format('M d, Y') : '-'
        ];
    }
}