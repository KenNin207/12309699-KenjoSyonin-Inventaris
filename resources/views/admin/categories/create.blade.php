@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('header', 'Add Category Forms')

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
        

        
        <form action="{{ route('categories.store') }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label class="form-label fw-bold">Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
               value="{{ old('name') }}" required placeholder="Contoh: Alat Dapur">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
    <label class="form-label fw-bold">Division PJ</label>
    <select name="division" class="form-select @error('division') is-invalid @enderror" required>
        <option value="" disabled selected>Select Division PJ</option>
        <option value="Sarpras" {{ old('division') == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
        <option value="Tata Usaha" {{ old('division') == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
        <option value="Tefa" {{ old('division') == 'Tefa' ? 'selected' : '' }}>Tefa</option>
    </select>
    @error('division')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

    <div class="text-end mt-4">
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn text-white" style="background-color: #6f42c1;">Save</button>
    </div>
</form>
    </div>
</div>
@endsection