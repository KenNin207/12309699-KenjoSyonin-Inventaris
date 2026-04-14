@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Utama Admin')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h5>Total Barang</h5>
                    <h2>{{ $totalBarang }}</h2> 
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5>Sedang Dipinjam</h5>
                    <h2>{{ $sedangDipinjam }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection