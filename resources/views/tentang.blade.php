@extends('layouts.app')

@section('content')

<style>
    .tentang-hero {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 1.25rem;
        color: #fff;
        padding: 2.25rem 2rem;
    }
    .tentang-hero .icon-badge {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,.18);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.7rem;
        margin: 0 auto 1rem;
    }
    .highlight-card {
        border-radius: 1.25rem;
        border: 0;
    }
    .highlight-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .4rem;
    }
    .highlight-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #fee2e2;
        color: #ef4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .panel-card {
        border-radius: 1.25rem;
        border: 0;
    }
    .panel-title {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.25rem;
    }
    .panel-title i {
        color: #6366f1;
    }
    .menu-pill {
        display: flex;
        align-items: center;
        gap: .6rem;
        background: #f8f9fc;
        border: 1px solid #eef0f5;
        border-radius: .75rem;
        padding: .6rem .9rem;
        font-weight: 600;
        color: #374151;
        transition: background-color .15s ease;
    }
    .menu-pill:hover {
        background: #f1f1fb;
    }
    .menu-emoji {
        font-size: 1.2rem;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .65rem 0;
        border-bottom: 1px solid #f1f3f5;
    }
    .info-row:last-child {
        border-bottom: 0;
    }
    .info-label {
        display: flex;
        align-items: center;
        gap: .5rem;
        color: #6b7280;
        font-weight: 600;
        font-size: .9rem;
    }
    .info-label i {
        color: #8b5cf6;
    }
    .info-value {
        font-weight: 600;
        color: #1f2937;
        text-align: right;
    }
</style>

<div class="container py-5" style="max-width: 700px;">

    <!-- Header Utama -->
    <div class="tentang-hero text-center mb-4 shadow-sm">
        <div class="icon-badge">
            <i class="bi bi-egg-fried"></i>
        </div>
        <h3 class="fw-bold mb-2">POS Baron Aneka Mie</h3>
        <p class="mb-0 opacity-75">
            Menyajikan berbagai macam mie nusantara dalam satu tempat — mulai dari mie ayam, mie goreng, mie kuah, hingga mie pedas khas racikan sendiri.
        </p>
    </div>

    <!-- Ringkasan Keunggulan -->
    <div class="card highlight-card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3 text-center">
                <div class="col-4">
                    <div class="highlight-item">
                        <div class="highlight-icon"><i class="bi bi-egg"></i></div>
                        <h6 class="fw-bold text-danger mb-0 mt-1">100% Segar</h6>
                        <small class="text-muted">Mie & bumbu racikan sendiri</small>
                    </div>
                </div>
                <div class="col-4 border-start border-end">
                    <div class="highlight-item">
                        <div class="highlight-icon"><i class="bi bi-stars"></i></div>
                        <h6 class="fw-bold text-danger mb-0 mt-1">Aneka Rasa</h6>
                        <small class="text-muted">Banyak pilihan menu mie</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="highlight-item">
                        <div class="highlight-icon"><i class="bi bi-patch-check"></i></div>
                        <h6 class="fw-bold text-danger mb-0 mt-1">Halal</h6>
                        <small class="text-muted">Higienis & aman</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Andalan -->
    <div class="card panel-card shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="panel-title justify-content-center">
                <i class="bi bi-journal-text"></i> Menu Andalan
            </h5>
            <div class="row g-2">
                <div class="col-6">
                    <div class="menu-pill"><span class="menu-emoji">🍜</span> Mie Ayam</div>
                </div>
                <div class="col-6">
                    <div class="menu-pill"><span class="menu-emoji">🍝</span> Mie Goreng</div>
                </div>
                <div class="col-6">
                    <div class="menu-pill"><span class="menu-emoji">🌶️</span> Mie Pedas</div>
                </div>
                <div class="col-6">
                    <div class="menu-pill"><span class="menu-emoji">🍲</span> Mie Kuah</div>
                </div>
                <div class="col-6">
                    <div class="menu-pill"><span class="menu-emoji">🥢</span> Mie Yamin</div>
                </div>
                <div class="col-6">
                    <div class="menu-pill"><span class="menu-emoji">🍤</span> Mie Seafood</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Usaha -->
    <div class="card panel-card shadow-sm">
        <div class="card-body p-4">
            <h5 class="panel-title justify-content-center">
                <i class="bi bi-info-circle"></i> Informasi Usaha
            </h5>

            <div class="info-row">
                <span class="info-label"><i class="bi bi-shop"></i>Nama Usaha:</span>
                <span class="info-value">POS Baron Aneka Mie</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-person-badge"></i>Pemilik / Pengembang:</span>
                <span class="info-value">Dede Fajri Saputra</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-geo-alt"></i>Lokasi Usaha:</span>
                <span class="info-value">Tasikmalaya, Jawa Barat</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-clock"></i>Jam Operasional:</span>
                <span class="info-value">08:00 - 21:00 WIB</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-whatsapp"></i>Kontak / WhatsApp:</span>
                <span class="info-value">+62 812-3456-7890</span>
            </div>
        </div>
    </div>

</div>
@endsection