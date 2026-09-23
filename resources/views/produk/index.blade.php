@extends('layouts.app')

@section('title', 'Produk')

@section('content')

    @include('layouts.navbar')

    <style>
        .produk-hero {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 1rem;
            color: #fff;
            padding: 1.75rem 2rem;
        }
        .produk-hero .icon-badge {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,.18);
            border-radius: .75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        .produk-count-pill {
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
        .produk-table-card {
            border-radius: 1rem;
        }
        .produk-table thead th {
            text-transform: uppercase;
            font-size: .72rem;
            letter-spacing: .04em;
            color: #6b7280;
            background: #f8f9fc;
            border-bottom: 1px solid #eef0f5;
        }
        .produk-table tbody tr {
            transition: background-color .15s ease;
        }
        .produk-table tbody tr:hover {
            background-color: #f7f7fd;
        }
        .produk-foto {
            width: 48px;
            height: 48px;
            border-radius: .65rem;
            object-fit: cover;
            border: 1px solid #eef0f5;
        }
        .produk-foto-placeholder {
            width: 48px;
            height: 48px;
            border-radius: .65rem;
            background: #f1f1fb;
            color: #a5a6f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
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
        <div class="produk-hero d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-badge">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-1">Daftar Produk</h4>
                    <span class="produk-count-pill">
                        <i class="bi bi-boxes me-1"></i>
                        {{ $products->total() }} Produk Terdaftar
                    </span>
                </div>
            </div>
            <div>
                <a href="{{ route('produk.create') }}" class="btn btn-light fw-semibold d-inline-flex align-items-center gap-2 shadow-sm px-3">
                    <i class="bi bi-plus-lg"></i>
                    <span>Create</span>
                </a>
            </div>
        </div>

        <!-- Form Pencarian -->
        <div class="card border-0 shadow-sm mb-4 search-card">
            <div class="card-body p-3">
                <form action="{{ route('produk.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search nama produk">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Card Container Utama -->
        <div class="card border-0 shadow-sm produk-table-card overflow-hidden">

            <!-- Tabel Produk -->
            <div class="table-responsive">
                <table class="table produk-table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="ps-4 py-3" style="width: 50px;">#</th>
                            <th scope="col" class="py-3">User</th>
                            <th scope="col" class="py-3">Foto</th>
                            <th scope="col" class="py-3">Nama</th>
                            <th scope="col" class="py-3">Jenis</th>
                            <th scope="col" class="py-3">Harga Beli</th>
                            <th scope="col" class="py-3">Satuan</th>
                            <th scope="col" class="py-3">Harga Jual</th>
                            <th scope="col" class="py-3 text-center">Stok</th>
                            <th scope="col" class="pe-4 py-3 text-center" style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="ps-4">
                                    <span class="row-index-badge">{{ $products->firstItem() + $loop->index }}</span>
                                </td>
                                <td class="fw-medium text-dark">
                                    <i class="bi bi-person-circle text-muted me-1"></i>{{ $product->user->name ?? '-' }}
                                </td>

                                <td>
                                    @if ($product->foto)
                                        <img src="{{ asset('storage/' . $product->foto) }}"
                                             alt="{{ $product->nama }}"
                                             class="produk-foto"
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/48?text=No+Image';">
                                    @else
                                        <div class="produk-foto-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                </td>

                                <td><span class="fw-bold text-dark text-capitalize">{{ $product->nama }}</span></td>

                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 fw-semibold rounded-pill">
                                        {{ $product->jenis->nama_jenis ?? $product->jenis->nama ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-secondary">Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</td>

                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 fw-semibold rounded-pill text-capitalize">
                                        {{ $product->satuan->nama_satuan ?? $product->satuan->nama ?? $product->satuan ?? '-' }}
                                    </span>
                                </td>

                                <td class="fw-semibold text-success">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $product->stok > 10 ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }} px-3 py-2 fw-bold">
                                        {{ $product->stok }}
                                    </span>
                                </td>

                                <td class="pe-4 text-center">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('produk.edit', $product) }}" class="btn btn-sm btn-outline-warning btn-icon-action">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Edit</span>
                                        </a>

                                        <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger btn-icon-action"
                                                onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                                <i class="bi bi-trash3"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="empty-state-icon">
                                        <i class="bi bi-box"></i>
                                    </div>
                                    <p class="mb-0 fs-5 fw-semibold text-secondary">Data tidak tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="card-footer bg-white py-3 px-4 d-flex justify-content-between align-items-center border-top">
                <small class="text-muted">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                </small>
                <div>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>

@endsection