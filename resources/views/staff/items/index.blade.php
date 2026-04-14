@extends('layouts.app')

@section('title', 'Items Data')

@section('content')
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-4">
            <h5 class="fw-bold text-dark mb-1">Items Table</h5>
            <small class="text-muted mb-4 d-block">Data <span class="text-danger">.items</span></small>

            <div class="table-responsive">
                <table class="table align-middle table-borderless table-hover text-center">
                    <thead class="border-bottom text-muted">
                        <tr>
                            <th class="py-3">#</th>
                            <th>Category</th>
                            <th class="text-start">Name</th>
                            <th>Total</th>
                            <th>Available</th>
                            <th>Lending Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                            <tr class="border-bottom">
                                <td class="py-3">{{ $index + 1 }}</td>
                                <td>{{ $item->category->name ?? '-' }}</td>
                                <td class="text-start fw-semibold text-dark">{{ $item->name }}</td>
                                
                                <td>{{ $item->quantity }}</td>
                                
                                <td>
                                    @php
                                        // lendings_sum_total didapat otomatis dari query withSum di Controller
                                        $dipinjam = $item->lendings_sum_total ?? 0;
                                        $rusak = $item->repair ?? 0;
                                        $tersedia = $item->quantity - $rusak - $dipinjam;
                                    @endphp
                                    <span class="fw-bold {{ $tersedia > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $tersedia }}
                                    </span>
                                </td>
                                
                                <td>{{ $item->lendings_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection