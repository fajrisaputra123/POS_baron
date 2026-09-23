<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Login POS')

<!-- batas awal isi konten -->
@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center p-3">
    <div class="card border-0 login-card w-100">
        <div class="card-body p-4 p-sm-5 text-center">
            
            {{-- Logo / Branding --}}
            <div class="brand-logo mb-3">
                <div class="logo-icon">
                    <i class="bi bi-box-seam-fill fs-3 text-white"></i>
                </div>
            </div>

            <h3 class="fw-bold text-white mb-1 tracking-tight">POS DeFaz</h3>
            <p class="text-white-50 small mb-4">Masuk ke sistem kasir untuk memulai transaksi</p>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="alert alert-danger border-0 bg-danger bg-opacity-20 text-danger-light text-start small py-2.5 px-3 mb-4 rounded-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-1"></i> Email atau password salah.
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                
                {{-- Input Email --}}
                <div class="mb-3 text-start">
                    <label for="email" class="form-label text-white-50 small fw-medium">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text border-0 text-white-50">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                            class="form-control border-0 text-white placeholder-muted" 
                            placeholder="nama@perusahaan.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                {{-- Input Password --}}
                <div class="mb-4 text-start">
                    <label for="password" class="form-label text-white-50 small fw-medium">Password</label>
                    <div class="input-group">
                        <span class="input-group-text border-0 text-white-50">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" name="password" id="password" 
                            class="form-control border-0 text-white placeholder-muted" 
                            placeholder="••••••••" required>
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit" class="btn btn-gradient w-100 fw-semibold text-white py-2-5 mb-3">
                    Masuk ke Dasbor
                </button>
            </form>

            {{-- Footer --}}
            <div class="pt-2">
                <small class="text-white-50" style="font-size: 0.75rem;">&copy; {{ date('Y') }} POS System. Designed for Enterprise.</small>
            </div>

        </div>
    </div>
</div>

<style>
    /* Gradient Background - Dark Navy Elegant */
    .login-wrapper {
        min-height: 100vh;
        background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
    }

    /* Glassmorphism Card Style */
    .login-card {
        max-width: 420px;
        background: rgba(255, 255, 255, 0.04) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 24px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    }

    /* Icon Logo Glow Effect */
    .brand-logo {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .logo-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.5);
    }

    /* Custom Form Styling */
    .input-group {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .input-group:focus-within {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        background: rgba(255, 255, 255, 0.08);
    }

    .input-group-text {
        background: transparent !important;
        padding-left: 1.2rem;
    }

    .form-control {
        background: transparent !important;
        padding: 0.75rem 1rem 0.75rem 0.5rem;
        font-size: 0.95rem;
    }

    .form-control:focus {
        box-shadow: none !important;
    }

    .placeholder-muted::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }

    /* Button Gradient & Glow */
    .btn-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
        border: none;
        border-radius: 14px;
        padding-top: 0.8rem;
        padding-bottom: 0.8rem;
        font-size: 0.95rem;
        letter-spacing: 0.3px;
        box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.5);
    }

    .btn-gradient:active {
        transform: translateY(0);
    }

    .text-danger-light {
        color: #fca5a5;
    }
</style>
@endsection