@extends('layouts.app')

@section('content')
@include('layouts.navbar')

<div class="container py-4">

    <h3 class="fw-bold mb-1">Laporan Penjualan</h3>
    <p class="text-muted mb-4">Ringkasan transaksi yang sudah selesai (CLOSED)</p>

    <!-- Filter Tanggal -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body px-4 py-3">
            <form action="{{ route('laporan.penjualan') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ $tanggalSelesai }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                    <a href="{{ route('laporan.penjualan') }}" class="btn btn-outline-secondary px-3">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <small class="text-muted">Total Pendapatan</small>
                <h5 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <small class="text-muted">Jumlah Transaksi</small>
                <h5 class="fw-bold mb-0">{{ $totalTransaksi }}</h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <small class="text-muted">Cash</small>
                <h5 class="fw-bold mb-0">Rp {{ number_format($totalCash, 0, ',', '.') }}</h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <small class="text-muted">QRIS + Transfer</small>
                <h5 class="fw-bold mb-0">Rp {{ number_format($totalQris + $totalTransfer, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>

    <!-- Tabel Detail -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 px-4">
            <h5 class="fw-bold mb-0">Detail Transaksi</h5>
        </div>
        <div class="card-body px-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Jumlah Item</th>
                            <th>Metode Bayar</th>
                            <th class="text-end">Bayar</th>
                            <th class="text-end">Kembalian</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualans as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->created_at->format('d M Y, H:i') }}</td>
                            <td>{{ $p->user->name ?? '-' }}</td>
                            <td>{{ $p->itemPenjualan->sum('kuantitas') }}</td>
                            <td>
                                <span class="badge {{ $p->metode_pembayaran == 'CASH' ? 'bg-success' : 'bg-info' }}">
                                    {{ $p->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="text-end">Rp {{ number_format($p->bayar, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($p->kembalian, 0, ',', '.') }}</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Tidak ada transaksi pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($penjualans->count() > 0)
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="7" class="text-end">Total</td>
                            <td class="text-end">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection