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
<br>
    <div class="row">
    <div class="col-md-3">
        <div class="card bg-danger text-white shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Damaged Items</h6>
                        <h2 class="fw-bold mb-0">{{ $totalDamaged }}</h2>
                    </div>
                    <div class="opacity-50">
                        <i class="bi bi-tools fs-1"></i>
                    </div>
                </div>
                <small class="mt-2 d-block">Needs maintenance</small>
            </div>
        </div>
    </div>
</div>
@endsection