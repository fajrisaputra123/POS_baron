@extends('layouts.app')

@section('title', 'Manajemen Users')

@section('content')

    @include('layouts.navbar')

    <div class="container py-4">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800 fw-bold">Halaman Users</h1>
                <p class="text-muted small mb-0">Kelola pengguna aplikasi dan hak akses mereka dengan mudah.</p>
            </div>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary px-4 shadow-sm fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Create
                </a>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">
                <form action="{{ route('admin.users') }}" method="GET" class="mb-0">
                    <div class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="form-control" placeholder="Search username or email...">
                        <button class="btn btn-outline-secondary px-4" type="submit">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-danger">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase fs-7 text-muted" style="letter-spacing: 0.5px;">
                            <tr>
                                <th scope="col" class="ps-4 py-3" style="width: 5%">#</th>
                                <th scope="col" class="py-3">Name</th>
                                <th scope="col" class="py-3">Email</th>
                                <th scope="col" class="py-3" style="width: 15%">Role</th>
                                <th scope="col" class="py-3" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="align-middle">
                                    <th scope="row" class="ps-4 text-muted font-monospace">
                                        {{ $users->firstItem() + $loop->index }}
                                    </th>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    </td>
                                    <td>
                                        <span class="text-secondary small">{{ $user->email }}</span>
                                    </td>
                                    <td>
                                        <!-- Badge warna dinamis berdasarkan nama role -->
                                        @php $stranswers_role = strtolower($user->role?->name ?? ''); @endphp
                                        @if($stranswers_role === 'admin')
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 text-capitalize">
                                                {{ $user->role->name }}
                                            </span>
                                        @elseif($stranswers_role === 'kasir')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 text-capitalize">
                                                {{ $user->role->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border px-2 py-1">
                                                {{ $user->role?->name ?? 'Tanpa Role' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Tombol aksi outline modern & presisi -->
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning btn-sm px-3 me-1 fw-medium">
                                            Edit Akun
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm px-3 fw-medium" onclick="return confirm('Yakin hapus user ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted fs-5">Data pengguna tidak ditemukan.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination Section -->
        <div class="d-flex justify-content-end mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Kustom CSS Pendukung Layout Modern -->
    <style>
        .fs-7 { font-size: 0.75rem; }
        .bg-primary-subtle { background-color: #e3f2fd !important; }
        .text-primary { color: #0d6efd !important; }
        .bg-success-subtle { background-color: #e8f5e9 !important; }
        .text-success { color: #198754 !important; }
        .table > :not(caption) > * > * { border-bottom-color: #f1f3f5; }
        .card { border-radius: 12px; }
        .btn { border-radius: 8px; }
    </style>

@endsection