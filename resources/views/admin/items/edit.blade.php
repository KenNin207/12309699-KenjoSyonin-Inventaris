@extends('layouts.app')

@section('title', 'Edit Barang')
@section('header', 'Edit Data Barang')

@section('content')
    <div class="card shadow-sm col-md-8">
        <div class="card-body">

            <form action="{{ route('items.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="name" class="form-control" required value="{{ $item->name }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Barang</label>
                    <input type="number" name="quantity" class="form-control" required min="1"
                        value="{{ $item->quantity }}">
                </div>
                
                <div class="mb-3">
                    <label for="new_broke_item" class="form-label fw-bold">
                        New Broke Item <span class="text-warning">(currently: {{ $item->repair ?? 0 }})</span>
                    </label>

                    <input type="number" name="new_broke_item" id="new_broke_item" class="form-control" value="0" min="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan / Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ $item->description }}</textarea>
                </div>

                <div class="mt-4">
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Barang</button>
                </div>
            </form>

        </div>
    </div>
@endsection