@extends('layouts.app') 

@section('title', 'Lending Data')

@section('content')
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="m-0 fw-bold text-dark">Lending Table</h5>
                <small class="text-muted">Data of <span style="color: #d63384;">.lendings</span></small>
            </div>
            <div>
                <a href="{{ route('lendings.export') }}" class="btn text-white me-2 shadow-sm" style="background-color: #6f42c1;">
                    Export Excel
                </a>
                <a href="{{ route('lendings.create') }}" class="btn btn-success shadow-sm">
                    <i class="bi bi-plus-square"></i> Add
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-success bg-light border-success opacity-75 mb-4" style="background-color: #d1e7dd !important;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-borderless table-hover">
                    <thead class="border-bottom">
                        <tr>
                            <th class="py-3">#</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Name</th>
                            <th>Ket.</th>
                            <th>Date</th>
                            <th>Returned</th>
                            <th>Edited By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lendings as $index => $lending)
                            <tr class="border-bottom">
                                <td class="py-3">{{ $index + 1 }}</td>
                                
                                <td>{{ $lending->item->name ?? '-' }}</td>
                                
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
                                
                                <td class="fw-bold">{{ $lending->user->name ?? 'staff' }}</td>
                                
                                <td>
                                    @if($lending->status != 'returned')
                                        <form action="{{ route('lendings.return', $lending->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-warning btn-sm text-white shadow-sm">Return</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('lendings.destroy', $lending->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm shadow-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Belum ada data peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection