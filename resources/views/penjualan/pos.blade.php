@extends('layouts.app')

@section('title', 'POS')

@section('content')

@include('layouts.navbar')


    {{-- Alert Error dari Validasi Form --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Alert Error Kustom --}}
    @if (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Alert Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <h4 class="mb-3">
        {{ isset($mode) && $mode === 'edit' ? 'Edit Penjualan' : 'Tambah Penjualan' }}
    </h4>

    <div class="row">

        {{-- =================== PRODUK =================== --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body" style="max-height:70vh; overflow:auto">
                    <div class="mb-3">
                        <form method="GET"
                            action="{{ isset($mode) && $mode === 'edit' ? route('penjualan.edit', $sale->id) : route('penjualan.create') }}">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Cari produk..." onkeyup="this.form.submit()">
                        </form>
                    </div>

                    @foreach ($products as $product)
                        <form method="POST" action="{{ route('item-penjualan.store') }}" class="row mb-2">
                            @csrf
                            <input type="hidden" name="penjualan_id" value="{{ $sale->id }}">
                            <input type="hidden" name="produk_id" value="{{ $product->id }}">

                            <div class="col-7">
                                <button type="submit"
                                    class="btn btn-outline-primary w-100 text-start p-2 {{ isset($sale) && $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $product->foto ? asset('storage/' . $product->foto) : 'https://via.placeholder.com/45?text=No+Img' }}" alt="Gambar"
                                            class="rounded-circle" style="width:45px; height:45px; object-fit:cover;">

                                        <div>
                                            <div class="fw-semibold">{{ $product->nama }}</div>
                                            <small class="text-muted">
                                                Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                                @if(!empty($product->satuan))
                                                    / {{ $product->satuan }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </button>
                            </div>

                            <div class="col-3">
                                <input type="number" name="kuantitas" value="1" min="1" class="form-control"
                                    {{ isset($sale) && $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                            </div>

                            <div class="col-2">
                                <button type="submit"
                                    class="btn btn-primary w-100 {{ isset($sale) && $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                    +
                                </button>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- =================== KERANJANG =================== --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <table class="table table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th style="width: 80px;">Qty</th>
                            <th>Subtotal</th>
                            <th style="width: 70px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sale->itemPenjualan ?? [] as $item)
                            <tr>
                                <td>{{ $item->produk->nama ?? 'Produk Dihapus' }}</td>
                                <td>{{ $item->produk->satuan ?? '-' }}</td>
                                <td>Rp {{ number_format($item->produk->harga_jual ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('item-penjualan.update', $item->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="kuantitas" value="{{ $item->kuantitas }}"
                                            min="1" class="form-control form-control-sm text-center"
                                            onchange="this.form.submit()"
                                            {{ isset($sale) && $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                    </form>
                                </td>
                                <td>Rp
                                    {{ number_format($item->subtotal ?? $item->kuantitas * ($item->produk->harga_jual ?? 0), 0, ',', '.') }}
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('item-penjualan.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            {{ isset($sale) && $sale->status === 'COMPLETED' ? 'disabled' : '' }}>Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">Belum ada item di keranjang</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @php
                    $totalHarga = $sale->itemPenjualan ? $sale->itemPenjualan->sum(function ($item) {
                        return $item->subtotal ?? $item->kuantitas * ($item->produk->harga_jual ?? 0);
                    }) : 0;
                @endphp

                <div class="card-footer bg-white p-3 border-top-0">
                    <div class="fs-5 fw-bold mb-3">
                        Total: Rp {{ number_format($totalHarga, 0, ',', '.') }}
                    </div>

                    {{-- Form Process/Checkout --}}
                    <form method="POST" action="{{ route('penjualan.checkout', $sale->id) }}"
                        onsubmit="return confirm('Yakin ingin memproses transaksi ini?')">
                        @csrf

                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select mb-3 fw-semibold" required
                            onchange="toggleQrisDisplay(this.value)"
                            {{ isset($sale) && $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                            <option value="">Pilih Pembayaran</option>
                            <option value="CASH"
                                {{ isset($sale) && $sale->metode_pembayaran === 'CASH' ? 'selected' : '' }}>CASH</option>
                            <option value="QRIS"
                                {{ isset($sale) && $sale->metode_pembayaran === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                            <option value="TRANSFER"
                                {{ isset($sale) && $sale->metode_pembayaran === 'TRANSFER' ? 'selected' : '' }}>TRANSFER
                            </option>
                        </select>

                        {{-- Input Uang Diberikan dan Kembalian --}}
                        <div class="mb-3">
                            <label for="bayar" class="form-label text-muted fw-semibold mb-1">Uang Diberikan (Rp)</label>
                            <input type="number" name="bayar" id="bayar" class="form-control" placeholder="0" min="0" 
                                value="{{ old('bayar', $sale->bayar ?? '') }}" oninput="hitungKembalian()"
                                {{ isset($sale) && $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                        </div>

                        <div class="mb-3">
                            <label for="kembalian" class="form-label text-muted fw-semibold mb-1">Kembalian (Rp)</label>
                            <input type="text" id="kembalian_display" class="form-control bg-light fw-bold" value="Rp 0" readonly>
                            <input type="hidden" name="kembalian" id="kembalian" value="{{ old('kembalian', $sale->kembalian ?? 0) }}">
                        </div>

                        {{-- Box Foto QRIS (Default Tersembunyi) --}}
                        <div id="qris-box" class="text-center p-3 mb-3 bg-light border rounded-3 d-none">
                            <small class="fw-bold text-muted d-block mb-2">Scan QRIS di Bawah Ini:</small>
                            <div class="bg-white p-2 d-inline-block rounded border shadow-sm">
                              <img src="{{ asset('imeg/qris.jpeg') }}"
                                   alt="QRIS Pembayaran" 
                                   class="img-fluid rounded" 
                                   style="max-width: 200px;"
                                   onerror="this.onerror=null;this.src='https://via.placeholder.com/200x200?text=Foto+QRIS+Belum+Ada';">
                            </div>
                        </div>

                        <button type="submit" id="btn-checkout"
                            class="btn btn-success w-100 py-2 fw-semibold {{ isset($sale) && $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                            {{ isset($mode) && $mode === 'edit' ? 'Update Transaksi' : 'Checkout' }}
                        </button>
                    </form>

                    {{-- Form Pembatalan Transaksi --}}
                    <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin membatalkan transaksi?')" class="mt-2">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn btn-outline-danger w-100 py-2 fw-semibold {{ isset($sale) && $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                            Batalkan Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Script Kontrol Tampilan QRIS & Hitung Kembalian --}}
    <script>
        const totalHarga = {{ $totalHarga }};

        function hitungKembalian() {
            const bayarInput = document.getElementById('bayar');
            const kembalianDisplay = document.getElementById('kembalian_display');
            const kembalianHidden = document.getElementById('kembalian');
            const bayarVal = parseFloat(bayarInput.value) || 0;

            if (bayarInput.value === '' || isNaN(bayarVal)) {
                kembalianDisplay.value = 'Rp 0';
                kembalianDisplay.classList.remove('text-danger');
                kembalianHidden.value = 0;
                return;
            }

            const kembalian = bayarVal - totalHarga;

            if (kembalian < 0) {
                kembalianDisplay.value = 'Uang Kurang (Rp ' + Math.abs(kembalian).toLocaleString('id-ID') + ')';
                kembalianDisplay.classList.add('text-danger');
                kembalianHidden.value = 0;
            } else {
                kembalianDisplay.value = 'Rp ' + kembalian.toLocaleString('id-ID');
                kembalianDisplay.classList.remove('text-danger');
                kembalianHidden.value = kembalian;
            }
        }

        function toggleQrisDisplay(val) {
            const qrisBox = document.getElementById('qris-box');
            if (val === 'QRIS') {
                qrisBox.classList.remove('d-none');
            } else {
                qrisBox.classList.add('d-none');
            }
        }

        // Jalankan saat pertama dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const selectPembayaran = document.getElementById('metode_pembayaran');
            if (selectPembayaran) {
                toggleQrisDisplay(selectPembayaran.value);
            }
            hitungKembalian();
        });
    </script>

@endsection