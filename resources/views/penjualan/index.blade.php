@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

    @include('layouts.navbar')

    <div class="container py-4">
        <!-- Card Container Utama -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            
            <!-- Card Header -->
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom-0">
                <h4 class="fw-bold mb-0 text-dark">Halaman Penjualan</h4>
                <a href="{{ route('penjualan.create') }}" class="btn btn-primary fw-semibold px-3 py-2 rounded-3 shadow-sm">
                    + Create
                </a>
            </div>

            <!-- Card Body / Form Pencarian -->
            <div class="card-body px-4 pb-0">
                <form action="{{ route('penjualan.index') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" value="{{ request()->search }}" class="form-control py-2 shadow-none rounded-start-3" placeholder="Search penjualan">
                        <button class="btn btn-outline-secondary px-4 rounded-end-3" type="submit">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Penjualan -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 py-3" style="width: 50px;">#</th>
                            <th scope="col" class="py-3">Tanggal Transaksi</th>
                            <th scope="col" class="py-3">Kasir</th>
                            <th scope="col" class="py-3">Total Pembayaran</th>
                            <th scope="col" class="py-3 text-center">Metode Pembayaran</th>
                            <th scope="col" class="py-3 text-center">Status</th>
                            <th scope="col" class="pe-4 py-3 text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $sale)
                            <tr>
                                <th scope="row" class="ps-4 fw-semibold text-muted">{{ $sales->firstItem() + $loop->index }}</th>
                                <td class="text-secondary fw-medium">
                                    {{ $sale->created_at->translatedFormat('d-M-Y H:i:s') }}
                                </td>
                                <td class="fw-medium text-dark">{{ $sale->user->name ?? '-' }}</td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                                </td>
                                
                                <!-- Badge Metode Pembayaran -->
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-3 py-2 fw-semibold rounded-pill">
                                        {{ strtoupper($sale->metode_pembayaran) }}
                                    </span>
                                </td>

                                <!-- Badge Status -->
                                <td class="text-center">
                                    @if(strtoupper($sale->status) === 'CLOSED' || $sale->status == 'Selesai')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-bold rounded-pill">
                                            CLOSED
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 fw-bold rounded-pill">
                                            OPEN
                                        </span>
                                    @endif
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="pe-4 text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-sm btn-info text-white fw-semibold px-2 py-1 shadow-sm">
                                            Detail
                                        </a>
                                        <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-sm btn-warning fw-semibold px-2 py-1 shadow-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger fw-semibold px-2 py-1 shadow-sm"
                                                onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <p class="mb-0 fs-5 fw-semibold">Data Tidak Ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="card-footer bg-white py-3 px-4 d-flex justify-content-between align-items-center border-top-0">
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