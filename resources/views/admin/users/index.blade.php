@extends('layouts.app')

@section('title', 'Admin Accounts')
@section('header', 'Admin Accounts Table')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            @if(session('generated_password'))
                <hr>
                <p class="mb-0">
                    Sistem telah membuat password otomatis untuk akun ini:
                    <strong class="fs-5 ms-2">{{ session('generated_password') }}</strong>
                </p>
                <small class="text-danger">*Harap catat atau salin password ini karena tidak akan ditampilkan lagi setelah halaman
                    direfresh.</small>
            @endif

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                <span class="text-muted small d-block">Add, delete, update admin-accounts</span>
            </div>
            <div>

                @if(request()->routeIs('users.admin'))
                    <a href="{{ route('users.export.admin') }}" class="btn btn-sm text-white"
                        style="background-color: #6f42c1;">
                        Export Excel
                    </a>
                @elseif(request()->routeIs('users.staff'))
                    <a href="{{ route('users.export.staff') }}" class="btn btn-sm text-white"
                        style="background-color: #6f42c1;">
                        Export Excel
                    </a>
                @endif
                <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus"></i> Add
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span
                                    class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>
                                @if($user->role == 'staff')

                                    <form action="{{ route('users.reset-password', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin mereset password akun ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning btn-sm text-dark">
                                            Reset Password
                                        </button>
                                    </form>

                                @else
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                                        Edit
                                    </a>
                                @endif

                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection