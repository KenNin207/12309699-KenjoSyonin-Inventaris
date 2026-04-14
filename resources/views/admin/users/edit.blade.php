@extends('layouts.app')

@section('title', 'Edit Akun')
@section('header', 'Edit Account Forms')

@section('content')
<div class="card shadow-sm col-md-8">
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control" required value="{{ $user->name }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ $user->email }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Operator</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password (Kosongkan jika tidak ingin ganti)</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
            </div>
            <div class="text-end mt-4">
                <a href="{{ route('users.index', ['role' => $user->role]) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn text-white" style="background-color: #6f42c1;">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection