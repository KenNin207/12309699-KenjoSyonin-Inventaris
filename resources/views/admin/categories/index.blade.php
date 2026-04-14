@extends('layouts.app')

@section('title', 'Kategori')
@section('header', 'Categories Table')

@section('content')
@error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <span class="text-muted small">Add, delete, update categories</span>
            <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-plus"></i> Add
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Division PJ</th>
                        <th>Total Items</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->division ?? '-' }}</td>
                            <td>{{ $category->items_count }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
