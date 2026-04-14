@extends('layouts.app')

@section('title', 'Add Lending')

@section('content')
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-4">
            <h5 class="fw-bold text-dark mb-1">Lending Form</h5>
            <small class="text-muted mb-4 d-block">Please <span class="text-danger">fill-all</span> input form with right
                value.</small>

            @if(session('error'))
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #842029; border-color: #f5c2c7;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('lendings.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}"
                        required>
                </div>

                <div id="dynamic-items-container">

                    <div class="item-block border p-3 mb-3 bg-white shadow-sm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Items</label>
                            <select name="item_id[]" class="form-select" required>
                                <option value="">Select Items</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} (Stok: {{ $item->quantity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Total</label>
                            <input type="number" name="total[]" class="form-control" placeholder="total item" min="1"
                                required>
                        </div>
                    </div>

                </div>

                <div class="mb-4">
                    <button type="button" id="btn-more" class="btn btn-link text-info text-decoration-none p-0 fw-bold">
                        <i class="bi bi-chevron-down"></i> More
                    </button>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Ket.</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                </div>

                <style>
                    .sig-canvas {
                        border: 2px dashed #ccc;
                        background: #f9f9f9;
                        cursor: crosshair;
                    }
                </style>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-primary">Meminjam Sampai Tanggal (Due Date)</label>
                    <input type="date" name="due_date" class="form-control" required min="{{ date('Y-m-d') }}">
                    <small class="text-muted">*Tentukan kapan barang harus dikembalikan.</small>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Staff Signature</label>
                        <div class="sig-canvas-container">
                            <canvas id="staff-pad" class="sig-canvas" width="300" height="150"></canvas>
                            <input type="hidden" name="staff_signature" id="staff-sig-input">
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0" id="clear-staff">Clear
                            Signature</button>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Borrower Signature</label>
                        <p>Saya yang bertanda tangan di bawah ini telah siap menerima konsekuensi yang ada jika peminjaman melewati batas waktu dan/atau jumlah barang yang di kembalikan tidak sesuai dengan yang diharapkan.</p>
                        <div class="sig-canvas-container">
                            <canvas id="borrower-pad" class="sig-canvas" width="300" height="150"></canvas>
                            <input type="hidden" name="borrower_signature" id="borrower-sig-input">
                        </div>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0" id="clear-borrower">Clear
                            Signature</button>
                    </div>
                </div>
                
                <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

                <script>
                    // 1. Inisialisasi Pad untuk Staff dan Peminjam
                    const staffPad = new SignaturePad(document.getElementById('staff-pad'));
                    const borrowerPad = new SignaturePad(document.getElementById('borrower-pad'));

                    // 2. Fungsi Hapus
                    document.getElementById('clear-staff').addEventListener('click', () => staffPad.clear());
                    document.getElementById('clear-borrower').addEventListener('click', () => borrowerPad.clear());

                    // 3. Logika Sebelum Submit: Ubah coretan kanvas jadi teks Base64
                    document.querySelector('form').addEventListener('submit', function (e) {
                        if (staffPad.isEmpty() || borrowerPad.isEmpty()) {
                            e.preventDefault();
                            alert("Please provide both signatures before submitting!");
                        } else {
                            // Masukkan data gambar ke hidden input
                            document.getElementById('staff-sig-input').value = staffPad.toDataURL();
                            document.getElementById('borrower-sig-input').value = borrowerPad.toDataURL();
                        }
                    });
                </script>

                <div>
                    <button type="submit" class="btn text-white px-4" style="background-color: #6f42c1;">Submit</button>
                    <a href="{{ route('lendings.index') }}" class="btn btn-light border px-4 ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('btn-more').addEventListener('click', function () {
            let container = document.getElementById('dynamic-items-container');

            // Buat elemen div baru
            let newRow = document.createElement('div');
            newRow.className = 'item-block border p-3 mb-3 bg-white shadow-sm position-relative';

            newRow.innerHTML = `
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="this.parentElement.remove()" style="font-size: 0.8rem; color: red;" aria-label="Close"></button>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Items</label>
                            <select name="item_id[]" class="form-select" required>
                                <option value="">Select Items</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} (Stok: {{ $item->quantity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Total</label>
                            <input type="number" name="total[]" class="form-control" placeholder="total item" min="1" required>
                        </div>
                    `;

            // Masukkan blok baru tersebut ke bagian bawah
            container.appendChild(newRow);
        });
    </script>
@endsection