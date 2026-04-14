<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LendingsExport implements FromCollection, WithHeadings, WithMapping
{
    // 1. Ambil data dari database beserta relasi item dan user
    public function collection()
    {
        return Lending::with(['item', 'user'])->latest()->get();
    }

    // 2. Buat baris pertama (Judul Kolom)
    public function headings(): array
    {
        return [
            'Item',
            'Total',
            'Name',
            'Ket.',
            'Date',
            'Return Date',
            'Edited By'
        ];
    }

    // 3. Atur format data per baris
    public function map($lending): array
    {
        // Logika untuk mengecek tanggal kembali
        if ($lending->status == 'returned' && $lending->return_date != null) {
            // Jika sudah dikembalikan, format tanggalnya jadi 'Jan 14, 2023'
            $returnDate = \Carbon\Carbon::parse($lending->return_date)->format('M d, Y');
        } else {
            // Jika belum dikembalikan, isi dengan '-'
            $returnDate = '-';
        }

        return [
            $lending->item->name ?? '-',
            $lending->total,
            $lending->borrower_name,
            $lending->description,
            // Format tanggal peminjaman (created_at)
            $lending->created_at ? $lending->created_at->format('M d, Y') : '-',
            $returnDate,
            $lending->user->name ?? 'staff'
        ];
    }
}