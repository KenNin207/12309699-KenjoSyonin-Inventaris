@extends('layouts.app') 

@section('title', 'Lending Data')

@section('content')
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="m-0 fw-bold text-dark">Lending Table</h5>
                <small class="text-muted">Data of <span style="color: #d63384;">.lendings</span></small>
            </div>
            
            
                <div class="d-flex align-items-end gap-2 mb-3">
    <form action="{{ route('lendings.export') }}" method="GET" class="d-flex align-items-end gap-2">
        <div>
            <label class="form-label small text-muted">Start Date</label>
            <input type="date" name="start_date" class="form-control form-control-sm" required>
        </div>
        <div>
            <label class="form-label small text-muted">End Date</label>
            <input type="date" name="end_date" class="form-control form-control-sm" required>
        </div>
        <button type="submit" class="btn btn-sm text-white shadow-sm" style="background-color: #6f42c1;">
            <i class="bi bi-file-earmark-excel"></i> Export by Date
        </button>
    </form>
    
    <a href="{{ route('lendings.export') }}" class="btn btn-sm text-white shadow-sm" style="background-color: #6f42c1">
        Export All
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
                            <th>Due Date</th>
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
            <span class="{{ $lending->status == 'borrowed' && $lending->due_date < date('Y-m-d') ? 'text-danger fw-bold' : '' }}">
                {{ \Carbon\Carbon::parse($lending->due_date)->format('d F, Y') }}
            </span>
        </td>
                                
                                <td>
                                    @if($lending->status == 'returned')
                                        <span class="badge border border-success text-success bg-white px-2 py-1">returned</span>
                                    @else
                                        <span class="badge border border-warning text-warning bg-white px-2 py-1">not returned</span>
                                    @endif
                                </td>
                                
                                <td class="fw-bold">{{ $lending->user->name ?? 'staff' }}</td>
                                
                                <td>
                                <button type="button" class="btn btn-info btn-sm text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#sigModal{{ $lending->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <div class="modal fade" id="sigModal{{ $lending->id }}" tabindex="-1" aria-labelledby="sigModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h6 class="modal-title fw-bold" id="sigModalLabel">Borrower Signature</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center pt-0">
                                                <small class="text-muted d-block mb-2">Peminjam: {{ $lending->borrower_name }}</small>
                                                
                                                @if($lending->borrower_signature)
                                                    <img src="{{ $lending->borrower_signature }}" class="img-fluid border shadow-sm" alt="Signature">
                                                @else
                                                    <p class="text-danger small">No signature data found.</p>
                                                @endif
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-secondary btn-sm w-100" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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