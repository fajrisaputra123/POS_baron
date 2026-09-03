@extends('layouts.app')

@section('title', 'Produk')

@section('content')

    @include('layouts.navbar')

    <div class="container py-4">
        <!-- Card Container Utama -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            
            <!-- Card Header -->
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom-0">
                <h4 class="fw-bold mb-0 text-dark">Daftar Produk</h4>
                @can('create', App\Models\Produk::class)
                    <a href="{{ route('produk.create') }}" class="btn btn-primary fw-semibold px-3 py-2 rounded-3 shadow-sm">
                        +Create
                    </a>
                @endcan
            </div>

            <!-- Card Body / Form Pencarian -->
            <div class="card-body px-4 pb-0">
                <form action="{{ route('produk.index') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control py-2 shadow-none rounded-start-3" placeholder="Search nama produk">
                        <button class="btn btn-outline-secondary px-4 rounded-end-3" type="submit">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Produk -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4 py-3" style="width: 50px;">#</th>
                            <th scope="col" class="py-3">User</th>
                            <th scope="col" class="py-3">Foto</th>
                            <th scope="col" class="py-3">Nama</th>
                            <th scope="col" class="py-3">Jenis</th> <!-- Header Kolom Jenis -->
                            <th scope="col" class="py-3">Harga Beli</th>
                            <th scope="col" class="py-3">Harga Jual</th>
                            <th scope="col" class="py-3 text-center">Stok</th>
                            <th scope="col" class="pe-4 py-3 text-center" style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <th scope="row" class="ps-4 fw-semibold text-muted">{{ $products->firstItem() + $loop->index }}</th>
                                <td class="fw-medium text-dark">{{ $product->user->name ?? '-' }}</td>

                                <td>
                                    @if ($product->foto)
                                        <img src="{{ asset('storage/' . $product->foto) }}" 
                                             alt="{{ $product->nama }}" 
                                             class="rounded-3 border shadow-sm object-fit-cover" 
                                             style="width: 48px; height: 48px;" 
                                             onerror="this.onerror=null;this.src='https://via.placeholder.com/48?text=No+Image';">
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">Tidak ada foto</span>
                                    @endif
                                </td>

                                <td><span class="fw-bold text-dark text-capitalize">{{ $product->nama }}</span></td>
                                
                                <!-- Baris Data Jenis -->
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 fw-semibold rounded-pill">
                                        {{ $product->jenis->nama_jenis ?? $product->jenis->nama ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-secondary">Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                                <td class="fw-semibold text-success">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $product->stok > 10 ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }} px-3 py-2 fw-bold">
                                        {{ $product->stok }}
                                    </span>
                                </td>
                                
                                <td class="pe-4 text-center">
                                    <div class="d-inline-flex gap-1">
                                        @can('update', $product)
                                            <a href="{{ route('produk.edit', $product) }}" class="btn btn-sm btn-warning fw-semibold px-2 py-1 shadow-sm">Edit</a>
                                        @endcan
                                        @can('delete', $product)
                                            <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger fw-semibold px-2 py-1 shadow-sm"
                                                    onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <p class="mb-0 fs-5 fw-semibold">Data tidak tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="card-footer bg-white py-3 px-4 d-flex justify-content-between align-items-center border-top-0">
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