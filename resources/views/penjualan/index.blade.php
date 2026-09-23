@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

    @include('layouts.navbar')

    <style>
        .penjualan-hero {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 1rem;
            color: #fff;
            padding: 1.75rem 2rem;
        }
        .penjualan-hero .icon-badge {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,.18);
            border-radius: .75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        .penjualan-count-pill {
            background: rgba(255,255,255,.18);
            border-radius: 2rem;
            padding: .35rem .9rem;
            font-size: .85rem;
            font-weight: 600;
        }
        .search-card {
            border-radius: 1rem;
        }
        .search-card .input-group-text {
            background: #fff;
            border-right: 0;
        }
        .search-card input.form-control {
            border-left: 0;
        }
        .search-card input.form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        .penjualan-table-card {
            border-radius: 1rem;
        }
        .penjualan-table thead th {
            text-transform: uppercase;
            font-size: .72rem;
            letter-spacing: .04em;
            color: #6b7280;
            background: #f8f9fc;
            border-bottom: 1px solid #eef0f5;
        }
        .penjualan-table tbody tr {
            transition: background-color .15s ease;
        }
        .penjualan-table tbody tr:hover {
            background-color: #f7f7fd;
        }
        .row-index-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #eef0fd;
            color: #6366f1;
            font-weight: 700;
            font-size: .8rem;
        }
        .btn-icon-action {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            border-radius: .5rem;
            font-weight: 600;
            font-size: .8rem;
            padding: .35rem .65rem;
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
        <div class="penjualan-hero d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-badge">
                    <i class="bi bi-cart-check-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Halaman Penjualan</h4>
                    <span class="penjualan-count-pill">
                        <i class="bi bi-receipt me-1"></i>
                        {{ $sales->total() }} Transaksi Tercatat
                    </span>
                </div>
            </div>
            <div class="d-flex gap-2">
                @if($sales->first())
                    <a href="{{ route('penjualan.cetak', $sales->first()->id) }}" target="_blank" class="btn btn-outline-light fw-semibold d-inline-flex align-items-center gap-2 px-3">
                        <i class="bi bi-printer"></i>
                        <span>Cetak Struk Terakhir</span>
                    </a>
                @endif
                <a href="{{ route('penjualan.create') }}" class="btn btn-light fw-semibold d-inline-flex align-items-center gap-2 shadow-sm px-3">
                    <i class="bi bi-plus-lg"></i>
                    <span>Create</span>
                </a>
            </div>
        </div>

        <!-- Form Pencarian -->
        <div class="card border-0 shadow-sm mb-4 search-card">
            <div class="card-body p-3">
                <form action="{{ route('penjualan.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="Search penjualan">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('penjualan.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Card Container Utama -->
        <div class="card border-0 shadow-sm penjualan-table-card overflow-hidden">

            <!-- Tabel Penjualan -->
            <div class="table-responsive">
                <table class="table penjualan-table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="ps-4 py-3" style="width: 50px;">#</th>
                            <th scope="col" class="py-3">Tanggal Transaksi</th>
                            <th scope="col" class="py-3">Kasir</th>
                            <th scope="col" class="py-3">Total Pembayaran</th>
                            <th scope="col" class="py-3">Dibayar</th>
                            <th scope="col" class="py-3">Kembalian</th>
                            <th scope="col" class="py-3 text-center">Metode Pembayaran</th>
                            <th scope="col" class="py-3 text-center">Status</th>
                            <th scope="col" class="pe-4 py-3 text-center" style="width: 210px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $sale)
                            <tr>
                                <td class="ps-4">
                                    <span class="row-index-badge">{{ $sales->firstItem() + $loop->index }}</span>
                                </td>
                                <td class="text-secondary fw-medium">
                                    <i class="bi bi-calendar3 text-muted me-1"></i>
                                    {{ $sale->created_at->translatedFormat('d-M-Y H:i:s') }}
                                </td>
                                <td class="fw-medium text-dark">
                                    <i class="bi bi-person-circle text-muted me-1"></i>{{ $sale->user->name ?? '-' }}
                                </td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                                </td>

                                <!-- Kolom Dibayar -->
                                <td class="fw-medium text-dark">
                                    Rp {{ number_format($sale->bayar ?? 0, 0, ',', '.') }}
                                </td>

                                <!-- Kolom Kembalian -->
                                <td class="fw-medium text-primary">
                                    Rp {{ number_format($sale->kembalian ?? 0, 0, ',', '.') }}
                                </td>

                                <!-- Badge Metode Pembayaran -->
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-3 py-2 fw-semibold rounded-pill">
                                        @if(strtoupper($sale->metode_pembayaran) === 'CASH')
                                            <i class="bi bi-cash-stack me-1"></i>
                                        @else
                                            <i class="bi bi-credit-card me-1"></i>
                                        @endif
                                        {{ strtoupper($sale->metode_pembayaran) }}
                                    </span>
                                </td>

                                <!-- Badge Status -->
                                <td class="text-center">
                                    @if(strtoupper($sale->status) === 'CLOSED' || $sale->status == 'Selesai')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-bold rounded-pill">
                                            <i class="bi bi-check-circle-fill me-1"></i>CLOSED
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 fw-bold rounded-pill">
                                            <i class="bi bi-clock-fill me-1"></i>OPEN
                                        </span>
                                    @endif
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="pe-4 text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-sm btn-outline-info btn-icon-action">
                                            <i class="bi bi-eye"></i>
                                            <span>Detail</span>
                                        </a>
                                        <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-sm btn-outline-warning btn-icon-action">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger btn-icon-action"
                                                onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                                <i class="bi bi-trash3"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-cart-x"></i>
                                    </div>
                                    <p class="mb-0 fs-5 fw-semibold text-secondary">Data Tidak Ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="card-footer bg-white py-3 px-4 d-flex justify-content-between align-items-center border-top">
                <small class="text-muted">
                    Showing {{ $sales->firstItem() ?? 0 }} to {{ $sales->lastItem() ?? 0 }} of {{ $sales->total() }} results
                </small>
                <div>
                    {{ $sales->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>

@endsection