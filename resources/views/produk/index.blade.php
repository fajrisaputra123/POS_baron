@extends('layouts.app')

@section('title', 'Produk')

@section('content')

    @include('layouts.navbar')

    <h1>Produk</h1>
    @can('create', App\Models\Produk::class)
        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
    @endcan

    <form action="{{ route('admin.produk.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="Search nama produk">
            <button class="btn btn-outline-secondary" type="submit">
                Search
            </button>
        </div>
    </form>

    <table class="table align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User</th>
                <th scope="col">Foto</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga beli</th>
                <th scope="col">Harga jual</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr class="align-middle">
                    <th scope="row">{{ $products->firstItem() + $loop->index }}</th>
                    <td>{{ $product->user->name ?? '-' }}</td>

                    <td>
                        @if ($product->foto)
                            <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}" width="60"
                                height="60" style="object-fit: cover;" class="img-thumbnail">
                        @else
                            <span class="badge bg-secondary">Tidak ada foto</span>
                        @endif
                    </td>

                    <td>{{ $product->nama }}</td>
                    <td>Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                    <td>{{ $product->stok }}</td>
                    
                    <!-- PERBAIKAN UTAMA: d-flex dihapus agar mengikuti align-middle bawaan tabel -->
                    <td>
                        @can('update', $product)
                            <!-- Ditambahkan me-1 untuk memberi jarak ke tombol hapus -->
                            <a href="{{ route('admin.produk.edit', $product) }}" class="btn btn-warning me-1">Edit</a>
                        @endcan
                        @can('delete', $product)
                            <form action="{{ route('admin.produk.destroy', $product) }}" method="POST" class="d-inline mb-0">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger"
                                    onclick="return confirm('Apakah anda yakin akan menghapus produk ini?')">
                                    Hapus
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h1>Data tidak tersedia.</h1>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->links() }}

@endsection