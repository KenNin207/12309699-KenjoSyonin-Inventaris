@extends('layouts.app')

@section('title', 'Data Barang')
@section('header', 'Kelola Data Barang')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-right py-3">
            <h6 class="m-0 fw-bold text-primary">Daftar Inventaris</h6>
            <div>
                <a href="{{ route('items.export') }}" class="btn btn-sm text-white" style="background-color: #6f42c1;">
                    Export Excel
                </a>
                <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Barang
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah Tersedia</th>
                            <th>Dipinjam</th>
                            <th>Repair</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category->name ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @if($item->lendings_count > 0)
                                        <a href="{{ route('items.lendings', $item->id) }}"
                                            class="text-primary fw-bold text-decoration-none">
                                            {{ $item->lendings_count }}
                                        </a>
                                        kali
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>{{ $item->repair ?? 0 }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection