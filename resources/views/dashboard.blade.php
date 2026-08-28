<!-- memanggil layout app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke tittle untuk ditampilkan -->
@section('title', 'Login')

<!-- batas awal isi konten -->
@section('content')

@include('layouts.navbar')

<div class="container py-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">Ringkasan Hari Ini</h2>
        <p class="text-muted mb-0">{{ $tanggalHariIni->format('d F Y') }}</p>
    </div>

    @can('viewAny', App\Models\User::class)
        {{-- ==================== TODAY'S SALES ==================== --}}
        <h6 class="text-uppercase text-muted fw-bold small mb-3">Today's Sales</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:56px; height:56px;">
                            <i class="bi bi-cash-coin text-primary fs-4"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Nilai Penjualan Hari ini</div>
                            <div class="fs-4 fw-bold text-dark">Rp {{ number_format($ringkasan['total_penjualan']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:56px; height:56px;">
                            <i class="bi bi-receipt text-info fs-4"></i>
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
        <h6 class="text-uppercase text-muted fw-bold small mb-3">Cash & Payment Status</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:56px; height:56px;">
                            <i class="bi bi-cash-stack text-success fs-4"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total pembayaran tunai</div>
                            <div class="fs-4 fw-bold text-dark">Rp {{ number_format($ringkasan['total_cash']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:56px; height:56px;">
                            <i class="bi bi-credit-card text-warning fs-4"></i>
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
    <h6 class="text-uppercase text-muted fw-bold small mb-3">Critical Inventory Status</h6>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h6 class="mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                        Daftar produk stok rendah
                    </h6>
                </div>
                <div class="card-body pt-2">
                    <table class="table table-sm align-middle mb-2">
                        <thead>
                            <tr class="text-muted small">
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkStokRendah as $index => $produk)
                                <tr>
                                    <td>{{ $produkStokRendah->firstItem() + $index }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td><span class="badge bg-warning text-dark">{{ $produk->stok }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3">
                                        <i class="bi bi-check-circle text-success me-1"></i>
                                        <span class="text-muted">Selalu produk berada dalam kondisi stok aman.</span>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h6 class="mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle-fill text-danger"></i>
                        Produk habis stok
                    </h6>
                </div>
                <div class="card-body pt-2">
                    <table class="table table-sm align-middle mb-2">
                        <thead>
                            <tr class="text-muted small">
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkStokHabis as $index => $produk)
                                <tr>
                                    <td>{{ $produkStokHabis->firstItem() + $index }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td><span class="badge bg-danger">{{ $produk->stok }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3">
                                        <i class="bi bi-check-circle text-success me-1"></i>
                                        <span class="text-muted">Selalu produk berada dalam kondisi stok aman.</span>
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
    <h6 class="text-uppercase text-muted fw-bold small mb-3">Best Seller Products</h6>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-3 pb-0">
            <h6 class="mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-trophy-fill text-warning"></i>
                Produk Terlaris
            </h6>
        </div>
        <div class="card-body pt-2">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-muted small">
                        <th scope="col">Nama</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Unit Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produkTerlaris as $produk)
                        <tr>
                            <td>{{ $produk->nama }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td><span class="badge bg-primary">{{ $produk->total_terjual }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-3">
                                <i class="bi bi-info-circle text-muted me-1"></i>
                                <span class="text-muted">Seluruh produk berada dalam kondisi stok aman.</span>
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