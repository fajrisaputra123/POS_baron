@extends('layouts.app')

@section('title', 'Jenis Produk')

@section('content')

@include('layouts.navbar')

<style>
    .jenis-hero {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 1rem;
        color: #fff;
        padding: 1.75rem 2rem;
    }
    .jenis-hero .icon-badge {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,.18);
        border-radius: .75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    .jenis-count-pill {
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
    .jenis-table-card {
        border-radius: 1rem;
    }
    .jenis-table thead th {
        text-transform: uppercase;
        font-size: .74rem;
        letter-spacing: .04em;
        color: #6b7280;
        background: #f8f9fc;
        border-bottom: 1px solid #eef0f5;
    }
    .jenis-table tbody tr {
        transition: background-color .15s ease;
    }
    .jenis-table tbody tr:hover {
        background-color: #f7f7fd;
    }
    .jenis-avatar {
        width: 38px;
        height: 38px;
        border-radius: .6rem;
        background: linear-gradient(135deg, #a5b4fc, #6366f1);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .95rem;
        flex-shrink: 0;
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
        gap: .35rem;
        border-radius: .5rem;
        font-weight: 600;
        font-size: .82rem;
        padding: .38rem .75rem;
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

<div class="container my-4">

    <!-- Notifikasi Error -->
    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Hero Header -->
    <div class="jenis-hero d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 shadow-sm">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-badge">
                <i class="bi bi-tags-fill"></i>
            </div>
            <div>
                <h1 class="h4 fw-bold mb-1">Daftar Jenis</h1>
                <span class="jenis-count-pill">
                    <i class="bi bi-box-seam me-1"></i>
                    {{ method_exists($jenis, 'total') ? $jenis->total() : $jenis->count() }} Jenis Terdaftar
                </span>
            </div>
        </div>
        <div>
            <a href="{{ route('jenis.create') }}" class="btn btn-light fw-semibold d-inline-flex align-items-center gap-2 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i>
                <span>Create</span>
            </a>
        </div>
    </div>

    <!-- Filter & Form Pencarian -->
    <div class="card border-0 shadow-sm mb-4 search-card">
        <div class="card-body p-3">
            <form action="{{ route('jenis.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Cari berdasarkan nama jenis...">
                    <button class="btn btn-primary px-4 fw-semibold" type="submit">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('jenis.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Jenis -->
    <div class="card border-0 shadow-sm jenis-table-card overflow-hidden">
        <div class="table-responsive">
            <table class="table jenis-table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col" class="ps-4" style="width: 10%;">#</th>
                        <th scope="col" style="width: 65%;">Nama Jenis</th>
                        <th scope="col" class="text-center pe-4" style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jenis as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="row-index-badge">
                                {{ method_exists($jenis, 'firstItem') ? $jenis->firstItem() + $loop->index : $loop->iteration }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="jenis-avatar">
                                    {{ strtoupper(substr($item->nama_jenis, 0, 1)) }}
                                </div>
                                <span class="fw-semibold text-dark">
                                    {{ $item->nama_jenis }}
                                </span>
                            </div>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-inline-flex align-items-center gap-2">
                                <a href="{{ route('jenis.edit', $item->id) }}" class="btn btn-sm btn-outline-warning btn-icon-action">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('jenis.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger btn-icon-action" onclick="return confirm('Apakah anda yakin ingin menghapus jenis ini?')">
                                        <i class="bi bi-trash3"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5">
                            <div class="empty-state-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <p class="mb-1 fs-5 fw-semibold text-secondary">Data jenis tidak tersedia.</p>
                            <small class="text-muted">Belum ada jenis produk yang ditambahkan atau tidak sesuai dengan pencarian.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Render Link Pagination jika ada -->
        @if(method_exists($jenis, 'hasPages') && $jenis->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $jenis->links() }}
        </div>
        @endif
    </div>

</div>

@endsection