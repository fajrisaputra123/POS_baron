@extends('layouts.app')

@section('content')
@include('layouts.navbar')

<style>
    .laporan-hero {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 1rem;
        color: #fff;
        padding: 1.75rem 2rem;
    }
    .laporan-hero .icon-badge {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,.18);
        border-radius: .75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    .filter-card {
        border-radius: 1rem;
    }
    .stat-card {
        border-radius: 1rem;
        border: 0;
        transition: transform .15s ease, box-shadow .15s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .75rem 1.5rem rgba(31,41,55,.08) !important;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: .75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .icon-indigo { background: linear-gradient(135deg,#a5b4fc,#6366f1); color:#fff; }
    .icon-cyan { background: linear-gradient(135deg,#67e8f9,#06b6d4); color:#fff; }
    .icon-green { background: linear-gradient(135deg,#86efac,#22c55e); color:#fff; }
    .icon-amber { background: linear-gradient(135deg,#fcd34d,#f59e0b); color:#fff; }
    .laporan-table-card {
        border-radius: 1rem;
    }
    .laporan-table thead th {
        text-transform: uppercase;
        font-size: .72rem;
        letter-spacing: .04em;
        color: #6b7280;
        background: #f8f9fc;
        border-bottom: 1px solid #eef0f5;
    }
    .laporan-table tbody tr:hover {
        background-color: #f7f7fd;
    }
    .row-index-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #eef0fd;
        color: #6366f1;
        font-weight: 700;
        font-size: .76rem;
    }
    .empty-state-icon {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: #f1f1fb;
        color: #a5a6f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 1rem;
    }
</style>

<div class="container py-4">

    <!-- Hero Header -->
    <div class="laporan-hero d-flex align-items-center gap-3 mb-4 shadow-sm">
        <div class="icon-badge">
            <i class="bi bi-bar-chart-line-fill"></i>
        </div>
        <div>
            <h3 class="fw-bold mb-1">Laporan Penjualan</h3>
            <p class="mb-0 opacity-75">Ringkasan transaksi yang sudah selesai (CLOSED)</p>
        </div>
    </div>

    <!-- Filter Tanggal -->
    <div class="card border-0 shadow-sm filter-card mb-4">
        <div class="card-body px-4 py-3">
            <form action="{{ route('laporan.penjualan') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar-event me-1 text-muted"></i>Tanggal Mulai
                    </label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar-check me-1 text-muted"></i>Tanggal Selesai
                    </label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ $tanggalSelesai }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                    <a href="{{ route('laporan.penjualan') }}" class="btn btn-outline-secondary px-3 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon icon-indigo">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <small class="text-muted">Total Pendapatan</small>
                        <h5 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon icon-cyan">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <small class="text-muted">Jumlah Transaksi</small>
                        <h5 class="fw-bold mb-0">{{ $totalTransaksi }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon icon-green">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <small class="text-muted">Cash</small>
                        <h5 class="fw-bold mb-0">Rp {{ number_format($totalCash, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon icon-amber">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <div>
                        <small class="text-muted">QRIS + Transfer</small>
                        <h5 class="fw-bold mb-0">Rp {{ number_format($totalQris + $totalTransfer, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail -->
    <div class="card border-0 shadow-sm laporan-table-card overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-list-ul text-primary"></i>
                Detail Transaksi
            </h5>
        </div>
        <div class="card-body px-4">
            <div class="table-responsive">
                <table class="table laporan-table table-hover align-middle">
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
                            <td><span class="row-index-badge">{{ $i + 1 }}</span></td>
                            <td class="text-secondary">
                                <i class="bi bi-calendar3 text-muted me-1"></i>{{ $p->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="fw-medium text-dark">
                                <i class="bi bi-person-circle text-muted me-1"></i>{{ $p->user->name ?? '-' }}
                            </td>
                            <td>{{ $p->itemPenjualan->sum('kuantitas') }}</td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 fw-semibold {{ $p->metode_pembayaran == 'CASH' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-info-subtle text-info border border-info-subtle' }}">
                                    @if($p->metode_pembayaran == 'CASH')
                                        <i class="bi bi-cash-stack me-1"></i>
                                    @else
                                        <i class="bi bi-credit-card me-1"></i>
                                    @endif
                                    {{ $p->metode_pembayaran }}
                                </span>
                            </td>
                            <td class="text-end">Rp {{ number_format($p->bayar, 0, ',', '.') }}</td>
                            <td class="text-end text-primary fw-medium">Rp {{ number_format($p->kembalian, 0, ',', '.') }}</td>
                            <td class="text-end fw-bold text-success">Rp {{ number_format($p->total_pembayaran, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state-icon">
                                    <i class="bi bi-clipboard-x"></i>
                                </div>
                                <p class="mb-0 fs-6 fw-semibold text-secondary">Tidak ada transaksi pada periode ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($penjualans->count() > 0)
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="7" class="text-end">Total</td>
                            <td class="text-end text-success">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection