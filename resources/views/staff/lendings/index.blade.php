@extends('layouts.app')

@section('title', 'Peminjaman Barang')
@section('header', 'Transaksi Peminjaman')

@section('content')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold text-primary">Form Peminjaman</div>
            <div class="card-body">
                <form action="{{ route('lendings.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih Barang</label>
                        <select name="item_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Barang Tersedia --</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} (Stok: {{ $item->quantity }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="lending_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Catat Pinjaman</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Riwayat Peminjaman</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover m-0">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th>Peminjam</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lendings as $lending)
                                <tr>
                                    <td>{{ $lending->item->name }}</td>
                                    <td>{{ $lending->user->name }}</td>
                                    <td>{{ $lending->lending_date }}</td>
                                    <td>{{ $lending->return_date ?? '-' }}</td>
                                    <td>
                                        @if($lending->status === 'borrowed')
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @else
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lending->status === 'borrowed')
                                            <form action="{{ route('lendings.return', $lending->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm btn-success text-white">Kembalikan</button>
                                            </form>
                                        @else
                                            <span class="text-muted text-center">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada transaksi peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection