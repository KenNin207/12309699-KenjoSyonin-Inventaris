@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('header', 'Tambah Data Barang Baru')

@section('content')
<div class="card shadow-sm col-md-8">
    <div class="card-body">
        
        <form action="{{ route('items.store') }}" method="POST">
            @csrf <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="name" class="form-control" required placeholder="Contoh: Laptop Asus">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Barang</label>
                <input type="number" name="quantity" class="form-control" required min="1" placeholder="Contoh: 10">
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan / Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Contoh: Kondisi baru, diletakkan di lab rpl"></textarea>
            </div>

            <div class="mt-4">
                <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Simpan Barang</button>
            </div>
        </form>

    </div>
</div>
@endsection