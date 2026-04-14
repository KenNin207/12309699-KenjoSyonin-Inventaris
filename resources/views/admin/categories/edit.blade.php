@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('header', 'Edit Category Forms')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card shadow-sm col-md-8">
    <div class="card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Name</label>
                <input type="text" name="name" class="form-control" required value="{{ $category->name }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Division PJ</label>
                <select name="division" class="form-select" required>
                    @foreach(['Sarpras', 'Tata Usaha', 'Tefa'] as $div)
                        <option value="{{ $div }}" {{ $category->division_pj == $div ? 'selected' : '' }}>{{ $div }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-end mt-4">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn text-white" style="background-color: #6f42c1;">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection