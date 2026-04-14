@extends('layouts.app')

@section('title', 'Dashboard Staff')
@section('header', 'Dashboard Operator')

@section('content')
    <div class="alert alert-info">
        Selamat datang di panel operator. Anda dapat mengelola peminjaman barang di sini.
    </div>
    
    <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5>Sedang Dipinjam</h5>
                    {{-- <h2>{{ }}</h2> --}}
                </div>
            </div>
        </div>
@endsection