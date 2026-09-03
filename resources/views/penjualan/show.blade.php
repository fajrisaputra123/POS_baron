@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Detail Transaksi #{{ $penjualan->id }}</h4>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary btn-sm">
            &larr; Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Kasir:</strong> {{ $penjualan->user->name ?? '-' }}</p>
                    <p class="mb-1"><strong>Tanggal:</strong> {{ $penjualan->created_at->format('d M Y, H:i') }}</p>
                    <p class="mb-1">
                        <strong>Status:</strong>
                        <span class="badge {{ $penjualan->status === 'CLOSED' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $penjualan->status }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Metode Pembayaran:</strong> {{ $penjualan->metode_pembayaran ?? '-' }}</p>
                    <p class="mb-1"><strong>Total:</strong> Rp{{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</p>
                    <p class="mb-1"><strong>Bayar:</strong> Rp{{ number_format($penjualan->bayar ?? 0, 0, ',', '.') }}</p>
                    <p class="mb-1"><strong>Kembalian:</strong> Rp{{ number_format($penjualan->kembalian ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Daftar Item
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                   @forelse ($penjualan->itemPenjualan as $index => $item)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->produk->nama ?? '-' }}</td>
        <td class="text-end">Rp{{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
        <td class="text-center">{{ $item->kuantitas ?? 0 }}</td>
        <td class="text-end">
            Rp{{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center text-muted py-3">Tidak ada item.</td>
    </tr>
@endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th class="text-end">Rp{{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection