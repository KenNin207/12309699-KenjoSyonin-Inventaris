<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        // Menampilkan semua user (Admin dan Staff)
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required'
        ]);

        // Simpan data user ke database dengan password sementara
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('sementara123'), // Ini akan langsung diganti di langkah bawah
            'role' => $request->role,
        ]);

        // Ambil 4 karakter pertama dari email yang diketik
        $emailPrefix = substr($user->email, 0, 4);

        // Gabungkan 4 karakter email dengan ID (nomor) user yang baru saja terbuat
        $rawPassword = $emailPrefix . $user->id;

        // Timpa password sementara tadi dengan password yang sudah digabung
        $user->update([
            'password' => bcrypt($rawPassword)
        ]);

        // Kembalikan ke halaman index, sambil membawa data password yang belum dienkripsi
        return redirect()->route('users.index')
            ->with('success', 'Akun berhasil ditambahkan!')
            ->with('generated_password', $rawPassword);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Jika user mengisi password baru, maka update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index', ['role' => $request->role]);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah admin menghapus akunnya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }

    // Menampilkan khusus Admin
    public function adminList()
    {
        // Mencari user yang di kolom role-nya tertulis 'admin'
        $users = \App\Models\User::where('role', 'admin')->latest()->get();

        // Menggunakan tampilan tabel index yang sudah ada
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan khusus Staff
    public function staffList()
    {
        $users = \App\Models\User::where('role', 'staff')->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    // Fungsi untuk mereset password menjadi 4 huruf email + ID
    public function resetPassword($id)
    {
        // Cari data user berdasarkan ID yang diklik
        $user = \App\Models\User::findOrFail($id);

        // Ambil 4 karakter pertama dari email user tersebut
        $emailPrefix = substr($user->email, 0, 4);

        // Gabungkan 4 huruf email dengan nomor ID-nya
        $rawPassword = $emailPrefix . $user->id;

        // Update password di database dengan password baru yang sudah dienkripsi
        $user->update([
            'password' => bcrypt($rawPassword)
        ]);

        // Kembalikan ke halaman sebelumnya dengan membawa pesan sukses dan password baru
        return redirect()->back()
            ->with('success', 'Password akun ' . $user->name . ' berhasil di-reset!')
            ->with('generated_password', $rawPassword);
    }

    // Export khusus Admin
    public function exportAdmin()
    {
        return Excel::download(new UsersExport('admin'), 'admin-accounts.xlsx');
    }

    // Export khusus Staff
    public function exportStaff()
    {
        return Excel::download(new UsersExport('staff'), 'staff-accounts.xlsx');
    }

    // Menampilkan form edit profil
    public function editProfile()
    {
        // Ambil data user yang sedang login saat ini
        $user = auth()->user(); 
        return view('staff.users.edit', compact('user'));
    }

    //  Memproses perubahan data
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Validasi input 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Siapkan data dasar yang pasti diubah
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika kolom password diisi teks baru, masukkan ke dalam data yang akan di-update
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Lakukan proses update ke database
        $user->update($data);

        // Kembalikan ke halaman form dengan pesan sukses
        return redirect()->back()->with('success', 'Profile has been successfully updated!');
    }
}   