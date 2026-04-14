@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('header', 'Add Category Forms')

@section('content')
<div class="card shadow-sm col-md-8">
    <div class="card-body">
        
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Contoh: Alat Dapur">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Division PJ</label>
                <select name="division_pj" class="form-select" required>
                    <option value="" disabled selected>Select Division PJ</option>
                    <option value="Sarpras">Sarpras</option>
                    <option value="Tata Usaha">Tata Usaha</option>
                    <option value="Tefa">Tefa</option>
                </select>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn text-white" style="background-color: #6f42c1;">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection