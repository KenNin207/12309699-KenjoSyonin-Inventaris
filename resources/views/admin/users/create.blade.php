@extends('layouts.app')

@section('title', 'Tambah Akun')
@section('header', 'Add Account Forms')

@section('content')
<div class="card shadow-sm col-md-8">
    <div class="card-body">
        <p class="text-muted small mb-4">Please fill-all input form with right value.</p>
        
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control" required placeholder="KenNin">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="kennin@gmail.com">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Role</label>
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Operator (Staff)</option>
                </select>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn text-white" style="background-color: #6f42c1;">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection