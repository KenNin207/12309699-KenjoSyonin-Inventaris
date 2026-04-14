<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Admin Wikrama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), 
            'role' => 'admin',
        ]);

        // Membuat akun Staff/Operator
        User::create([
            'name' => 'Operator Wikrama',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('password'), 
            'role' => 'staff',
        ]);
    }
}