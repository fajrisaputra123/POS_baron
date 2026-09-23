@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
@include('layouts.navbar')

<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 px-4 border-bottom-0">
            <h4 class="fw-bold mb-0 text-dark">Edit Produk</h4>
        </div>
        <div class="card-body px-4">
            <form action="{{ route('produk.update', $produk) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('Produk._form')
            </form>
        </div>
    </div>
</div>
@endsection