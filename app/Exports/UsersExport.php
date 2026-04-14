<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $role;

    // Menangkap role (admin/staff) dari controller
    public function __construct($role)
    {
        $this->role = $role;
    }

    // 1. Ambil data user sesuai role
    public function collection()
    {
        return User::where('role', $this->role)->get();
    }

    // 2. Buat Judul Kolom
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Password'
        ];
    }

    // 3. Atur isi per baris
    public function map($user): array
    {
        // Hitung rumus password bawaan pabrik
        $emailPrefix = substr($user->email, 0, 4);
        $defaultPassword = $emailPrefix . $user->id;

        // FAKTA: Mengecek apakah password di DB sama dengan rumus bawaan
        if (Hash::check($defaultPassword, $user->password)) {
            // Jika cocok, tampilkan password mentahnya
            $passwordText = $defaultPassword;
        } else {
            // Jika tidak cocok, berarti sudah diganti
            $passwordText = 'This account already edited the password';
        }

        return [
            $user->name,
            $user->email,
            $passwordText
        ];
    }
}