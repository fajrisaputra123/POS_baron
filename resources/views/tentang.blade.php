@extends('layouts.app')

@section('content')
<div class="container py-5 text-center" style="max-width: 650px;">
    <!-- Header Utama -->
    <h3 class="fw-bold text-dark mb-2">POS Baron Aneka Mie</h3>
    <p class="text-secondary mb-4">
        Menyajikan berbagai macam mie nusantara dalam satu tempat — mulai dari mie ayam, mie goreng, mie kuah, hingga mie pedas khas racikan sendiri.
    </p>

    <!-- Ringkasan Keunggulan -->
    <div class="p-4 border rounded-4 bg-light shadow-sm mb-4">
        <div class="row g-3">
            <div class="col-4">
                <h6 class="fw-bold text-danger mb-1">100% Segar</h6>
                <small class="text-muted fs-7">Mie & bumbu racikan sendiri</small>
            </div>
            <div class="col-4 border-start border-end">
                <h6 class="fw-bold text-danger mb-1">Aneka Rasa</h6>
                <small class="text-muted fs-7">Banyak pilihan menu mie</small>
            </div>
            <div class="col-4">
                <h6 class="fw-bold text-danger mb-1">Halal</h6>
                <small class="text-muted fs-7">Higienis & aman</small>
            </div>
        </div>
    </div>

    <!-- Menu Andalan -->
    <div class="p-4 border rounded-4 bg-white text-start shadow-sm mb-4">
        <h5 class="fw-bold text-dark mb-3 text-center">Menu Andalan</h5>
        <div class="row g-2 text-secondary">
            <div class="col-6 mb-2">🍜 Mie Ayam</div>
            <div class="col-6 mb-2">🍝 Mie Goreng</div>
            <div class="col-6 mb-2">🌶️ Mie Pedas</div>
            <div class="col-6 mb-2">🍲 Mie Kuah</div>
            <div class="col-6 mb-2">🥢 Mie Yamin</div>
            <div class="col-6 mb-2">🍤 Mie Seafood</div>
        </div>
    </div>

    <!-- Informasi Usaha -->
    <div class="p-4 border rounded-4 bg-white text-start shadow-sm">
        <h5 class="fw-bold text-dark mb-3 text-center">Informasi Usaha</h5>
        <div class="row g-2 text-secondary">
            <div class="col-5 fw-semibold">Nama Usaha:</div>
            <div class="col-7 text-dark fw-bold">POS Baron Aneka Mie</div>

            <div class="col-5 fw-semibold">Pemilik / Pengembang:</div>
            <div class="col-7 text-dark">Dede Fajri Saputra</div>

            <div class="col-5 fw-semibold">Lokasi Usaha:</div>
            <div class="col-7 text-dark">Tasikmalaya, Jawa Barat</div>

            <div class="col-5 fw-semibold">Jam Operasional:</div>
            <div class="col-7 text-dark">08:00 - 21:00 WIB</div>

            <div class="col-5 fw-semibold">Kontak / WhatsApp:</div>
            <div class="col-7 text-dark">+62 812-3456-7890</div>
        </div>
    </div>
</div>
@endsection