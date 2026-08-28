@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Produk</h2>

    <form action="{{ route('admin.produk.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        {{-- Input Gambar / Foto Produk --}}
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Produk</label>
            <input 
                type="file" 
                name="foto" 
                id="foto" 
                class="form-control @error('foto') is-invalid @enderror"
                accept="image/*"
            >
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Nama Produk --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name') }}" 
                required
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Harga Beli --}}
        <div class="mb-3">
            <label for="purchase_price" class="form-label">Harga Beli</label>
            <input 
                type="number" 
                name="purchase_price" 
                id="purchase_price" 
                class="form-control @error('purchase_price') is-invalid @enderror" 
                value="{{ old('purchase_price') }}" 
                required
            >
            @error('purchase_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Harga Jual --}}
        <div class="mb-3">
            <label for="selling_price" class="form-label">Harga Jual</label>
            <input 
                type="number" 
                name="selling_price" 
                id="selling_price" 
                class="form-control @error('selling_price') is-invalid @enderror" 
                value="{{ old('selling_price') }}" 
                required
            >
            @error('selling_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Stok --}}
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input 
                type="number" 
                name="stock" 
                id="stock" 
                class="form-control @error('stock') is-invalid @enderror" 
                value="{{ old('stock') }}" 
                required
            >
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection