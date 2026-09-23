<!-- memanggil layout app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke tittle untuk ditampilkan -->
@section('title', 'Login')

<!-- batas awal isi konten -->
@section('content')

@include('layouts.navbar')

<style>
    .dash-hero {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 1rem;
        color: #fff;
        padding: 1.75rem 2rem;
    }
    .dash-hero .icon-badge {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,.18);
        border-radius: .75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    .section-label {
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 700;
        font-size: .74rem;
        letter-spacing: .06em;
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-bottom: .9rem;
    }
    .section-label::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #eef0f5;
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
        width: 56px;
        height: 56px;
        border-radius: .85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .icon-blue { background: linear-gradient(135deg,#93c5fd,#3b82f6); color:#fff; }
    .icon-cyan { background: linear-gradient(135deg,#67e8f9,#06b6d4); color:#fff; }
    .icon-green { background: linear-gradient(135deg,#86efac,#22c55e); color:#fff; }
    .icon-amber { background: linear-gradient(135deg,#fcd34d,#f59e0b); color:#fff; }

    .panel-card {
        border-radius: 1rem;
        border: 0;
    }
    .panel-card .card-header {
        border-radius: 1rem 1rem 0 0;
    }
    .table > thead th {
        text-transform: uppercase;
        font-size: .7rem;
        letter-spacing: .04em;
        color: #6b7280;
        border-bottom: 1px solid #eef0f5;
    }
    .table > :not(caption) > * > * {
        border-bottom-color: #f1f3f5;
    }
    .empty-inline {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: 1rem 0;
    }
</style>

<div class="container py-4">

    <!-- Hero Header -->
    <div class="dash-hero d-flex align-items-center gap-3 mb-4 shadow-sm">
        <div class="icon-badge">
            <i class="bi bi-speedometer2"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-1">Ringkasan Hari Ini</h2>
            <p class="mb-0 opacity-75">{{ $tanggalHariIni->format('d F Y') }}</p>
        </div>
    </div>

    @can('viewAny', App\Models\User::class)
        {{-- ==================== TODAY'S SALES ==================== --}}
        <div class="section-label"><i class="bi bi-graph-up-arrow"></i> Today's Sales</div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon icon-blue">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Nilai Penjualan Hari ini</div>
                            <div class="fs-4 fw-bold text-dark">Rp {{ number_format($ringkasan['total_penjualan']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon icon-cyan">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Jumlah Transaksi Hari ini</div>
                            <div class="fs-4 fw-bold text-dark">{{ $ringkasan['total_transaksi'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== CASH & PAYMENT STATUS ==================== --}}
        <div class="section-label"><i class="bi bi-wallet2"></i> Cash &amp; Payment Status</div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon icon-green">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total pembayaran tunai</div>
                            <div class="fs-4 fw-bold text-dark">Rp {{ number_format($ringkasan['total_cash']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon icon-amber">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total pembayaran non-tunai</div>
                            <div class="fs-4 fw-bold text-dark">Rp {{ number_format($ringkasan['total_non_tunai']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    {{-- ==================== CRITICAL INVENTORY STATUS ==================== --}}
    <div class="section-label"><i class="bi bi-box-seam"></i> Critical Inventory Status</div>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card panel-card shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h6 class="mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                        Daftar produk stok rendah
                    </h6>
                </div>
                <div class="card-body pt-2">
                    <table class="table table-sm align-middle mb-2">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkStokRendah as $index => $produk)
                                <tr>
                                    <td class="text-muted">{{ $produkStokRendah->firstItem() + $index }}</td>
                                    <td class="fw-semibold text-dark">{{ $produk->nama }}</td>
                                    <td><span class="badge bg-warning text-dark rounded-pill">{{ $produk->stok }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-inline">
                                            <i class="bi bi-check-circle text-success"></i>
                                            <span class="text-muted">Selalu produk berada dalam kondisi stok aman.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $produkStokRendah->links() }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card panel-card shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h6 class="mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle-fill text-danger"></i>
                        Produk habis stok
                    </h6>
                </div>
                <div class="card-body pt-2">
                    <table class="table table-sm align-middle mb-2">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkStokHabis as $index => $produk)
                                <tr>
                                    <td class="text-muted">{{ $produkStokHabis->firstItem() + $index }}</td>
                                    <td class="fw-semibold text-dark">{{ $produk->nama }}</td>
                                    <td><span class="badge bg-danger rounded-pill">{{ $produk->stok }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-inline">
                                            <i class="bi bi-check-circle text-success"></i>
                                            <span class="text-muted">Selalu produk berada dalam kondisi stok aman.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $produkStokHabis->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== BEST SELLER PRODUCTS ==================== --}}
    <div class="section-label"><i class="bi bi-star"></i> Best Seller Products</div>
    <div class="card panel-card shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-3 pb-0">
            <h6 class="mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-trophy-fill text-warning"></i>
                Produk Terlaris
            </h6>
        </div>
        <div class="card-body pt-2">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Unit Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produkTerlaris as $produk)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $produk->nama }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td><span class="badge bg-primary rounded-pill">{{ $produk->total_terjual }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="empty-inline">
                                    <i class="bi bi-info-circle text-muted"></i>
                                    <span class="text-muted">Seluruh produk berada dalam kondisi stok aman.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<form action="{{ route('logout') }}" method="POST">
    @csrf
</form>

<!-- batas akhir isi konten -->
@endsection