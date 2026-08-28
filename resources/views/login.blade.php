<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke tittle untuk ditampilkan -->
@section('title', 'Login POS')

<!-- batas awal isi konten -->
@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <!-- Card Login Modern -->
                <div class="card border-0 shadow-lg login-card">
                    
                    <!-- Header Card dengan Desain Kece -->
                    <div class="card-header border-0 text-center py-4 bg-primary text-white position-relative overflow-hidden">
                        <div class="login-header-bg"></div>
                        <h4 class="fw-bold mb-1 position-relative z-index-2">Login POS</h4>
                        <p class="small text-white-50 mb-0 position-relative z-index-2">Silakan masuk ke akun Anda</p>
                    </div>

                    <!-- Body Card -->
                    <div class="card-body p-4 p-sm-5">
                        
                        <!-- Form Login (Tetap menggunakan route('auth') sesuai kodingan aslimu) -->
                        <form action="{{ route('auth') }}" method="POST">
                            @csrf
                            
                            <!-- Input Email -->
                            <div class="mb-3 text-start">
                                <label for="exampleInputEmail1" class="form-label text-secondary small fw-bold">Email address</label>
                                <input type="email" name="email" class="form-control form-control-lg fs-6" 
                                    id="exampleInputEmail1" placeholder="nama@email.com" required autofocus>
                            </div>

                            <!-- Input Password -->
                            <div class="mb-4 text-start">
                                <label for="exampleInputPassword1" class="form-label text-secondary small fw-bold">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg fs-6" 
                                    id="exampleInputPassword1" placeholder="Masukkan password" required>
                            </div>

                            <!-- Tombol Submit Lebar Penuh -->
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-2 fs-6">
                                Masuk Aplikasi
                            </button>
                        </form>

                    </div>
                </div>

                <!-- Footer Kecil -->
                <p class="text-center text-muted small mt-4">&copy; {{ date('Y') }} POS System.</p>

            </div>
        </div>
    </div>
</div>

<!-- Kustom CSS khusus untuk centering dan mempercantik -->
<style>
    /* Membuat halaman memenuhi tinggi layar dan background abu-abu soft modern */
    .login-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
    }

    /* Membuat kartu login melengkung halus */
    .login-card {
        border-radius: 16px;
        overflow: hidden;
        background: #ffffff;
    }

    /* Modifikasi input form agar lebih elegan saat diklik */
    .form-control-lg {
        border-radius: 10px;
        padding: 0.6rem 1rem;
        border: 1px solid #ced4da;
        background-color: #f8fafc;
        transition: all 0.2s ease-in-out;
    }

    .form-control-lg:focus {
        background-color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    /* Tombol login dengan efek transisi */
    .btn-lg {
        border-radius: 10px;
        transition: all 0.2s;
    }
    
    .btn-lg:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3) !important;
    }

    /* Ornamen gradasi di background header */
    .login-header-bg {
        position: absolute;
        top: -50%;
        left: -20%;
        width: 140%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(-15deg);
        z-index: 1;
    }
    
    .z-index-2 {
        position: relative;
        z-index: 2;
    }
</style>
@endsection