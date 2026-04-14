<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LendingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $start_date;
    protected $end_date;
// Menangkap tanggal dari Controller
    public function __construct($start = null, $end = null)
    {
        $this->start_date = $start;
        $this->end_date = $end;
    }

    public function collection()
    {
        $query = Lending::with(['item', 'user']);

        // Jika user input tanggal, saring datanya
        if ($this->start_date && $this->end_date) {
            // whereBetween itu perintah SQL untuk mencari data di antara dua nilai
            $query->whereBetween('created_at', [$this->start_date . " 00:00:00", $this->end_date . " 23:59:59"]);
        }

        return $query->latest()->get();
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
            'Due Date',
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
            $lending->created_at ? $lending->created_at->format('M d, Y') : '-',
            \Carbon\Carbon::parse($lending->due_date)->format('d/m/Y'),
            $returnDate,
            $lending->user->name ?? 'staff'
        ];
    }
}