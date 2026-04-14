@extends('layouts.app')

@section('title', 'Detail Peminjaman')
@section('header', 'Detail Peminjaman Barang')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h6 class="m-0 fw-bold text-primary" style="font-size: 1.1rem;">Lending Table</h6>
                <small class="text-muted">Data of <span class="text-danger">{{ $item->name }}</span></small>
            </div>
            <a href="{{ route('items.index') }}" class="btn btn-secondary btn-sm px-4">
                Back
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Name</th>
                            <th>Ket.</th>
                            <th>Date</th>
                            <th>Returned</th>
                            <th>Edited By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($item->lendings as $index => $lending)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                
                                <td>{{ $lending->total }}</td> 
                                <td>{{ $lending->borrower_name }}</td> 
                                <td>{{ $lending->description }}</td> 
                                
                                <td>{{ $lending->created_at->format('d F, Y') }}</td>
                                
                                <td>
                                    @if($lending->status == 'returned')
                                        <span class="badge border border-success text-success bg-white px-2 py-1">returned</span>
                                    @else
                                        <span class="badge border border-warning text-warning bg-white px-2 py-1">not returned</span>
                                    @endif
                                </td>
                                
                                <td class="fw-bold">{{ $lending->user->name ?? 'operator wikrama' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Belum ada riwayat peminjaman untuk barang ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection