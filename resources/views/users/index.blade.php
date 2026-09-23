@extends('layouts.app')

@section('title', 'Manajemen Users')

@section('content')

    @include('layouts.navbar')

    <style>
        .users-hero {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-radius: 1rem;
            color: #fff;
            padding: 1.75rem 2rem;
        }
        .users-hero .icon-badge {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,.18);
            border-radius: .75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        .users-count-pill {
            background: rgba(255,255,255,.18);
            border-radius: 2rem;
            padding: .35rem .9rem;
            font-size: .85rem;
            font-weight: 600;
        }
        .search-card {
            border-radius: 1rem;
        }
        .search-card .input-group-text {
            background: #fff;
            border-right: 0;
        }
        .search-card input.form-control {
            border-left: 0;
        }
        .search-card input.form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        .users-table-card {
            border-radius: 1rem;
        }
        .users-table thead th {
            text-transform: uppercase;
            font-size: .74rem;
            letter-spacing: .04em;
            color: #6b7280;
            background: #f8f9fc;
            border-bottom: 1px solid #eef0f5;
        }
        .users-table tbody tr {
            transition: background-color .15s ease;
        }
        .users-table tbody tr:hover {
            background-color: #f7f7fd;
        }
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: .6rem;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .95rem;
            flex-shrink: 0;
        }
        .avatar-admin { background: linear-gradient(135deg, #93c5fd, #3b82f6); }
        .avatar-kasir { background: linear-gradient(135deg, #86efac, #22c55e); }
        .avatar-other { background: linear-gradient(135deg, #d1d5db, #9ca3af); }
        .row-index-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #eef0fd;
            color: #6366f1;
            font-weight: 700;
            font-size: .8rem;
        }
        .btn-icon-action {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            border-radius: .5rem;
            font-weight: 600;
            font-size: .82rem;
            padding: .38rem .75rem;
        }
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: .78rem;
            padding: .3rem .7rem;
        }
        .empty-state-icon {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: #f1f1fb;
            color: #a5a6f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 1rem;
        }
    </style>

    <div class="container py-4">

        <!-- Hero Header -->
        <div class="users-hero d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-badge">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h1 class="h4 fw-bold mb-1">Halaman Users</h1>
                    <p class="mb-2 opacity-75 small">Kelola pengguna aplikasi dan hak akses mereka dengan mudah.</p>
                    <span class="users-count-pill">
                        <i class="bi bi-person-lines-fill me-1"></i>
                        {{ method_exists($users, 'total') ? $users->total() : $users->count() }} Pengguna Terdaftar
                    </span>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-light fw-semibold d-inline-flex align-items-center gap-2 shadow-sm px-3">
                    <i class="bi bi-plus-lg"></i>
                    <span>Create</span>
                </a>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="card border-0 shadow-sm mb-4 search-card">
            <div class="card-body p-3">
                <form action="{{ route('admin.users') }}" method="GET" class="mb-0">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control" placeholder="Search username or email...">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="card border-0 shadow-sm users-table-card overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table users-table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="ps-4 py-3" style="width: 5%">#</th>
                                <th scope="col" class="py-3">Name</th>
                                <th scope="col" class="py-3">Email</th>
                                <th scope="col" class="py-3" style="width: 15%">Role</th>
                                <th scope="col" class="py-3" style="width: 22%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="align-middle">
                                    <td class="ps-4">
                                        <span class="row-index-badge">
                                            {{ $users->firstItem() + $loop->index }}
                                        </span>
                                    </td>
                                    <td>
                                        @php $stranswers_role = strtolower($user->role?->name ?? ''); @endphp
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="user-avatar {{ $stranswers_role === 'admin' ? 'avatar-admin' : ($stranswers_role === 'kasir' ? 'avatar-kasir' : 'avatar-other') }}">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-bold text-dark">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary small">
                                            <i class="bi bi-envelope me-1 text-muted"></i>{{ $user->email }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($stranswers_role === 'admin')
                                            <span class="role-badge bg-primary-subtle text-primary border border-primary-subtle text-capitalize">
                                                <i class="bi bi-shield-fill-check"></i>{{ $user->role->name }}
                                            </span>
                                        @elseif($stranswers_role === 'kasir')
                                            <span class="role-badge bg-success-subtle text-success border border-success-subtle text-capitalize">
                                                <i class="bi bi-person-badge-fill"></i>{{ $user->role->name }}
                                            </span>
                                        @else
                                            <span class="role-badge bg-light text-muted border">
                                                <i class="bi bi-question-circle"></i>{{ $user->role?->name ?? 'Tanpa Role' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning btn-sm btn-icon-action">
                                                <i class="bi bi-pencil-square"></i>
                                                <span>Edit Akun</span>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger btn-sm btn-icon-action" onclick="return confirm('Yakin hapus user ini?')">
                                                    <i class="bi bi-trash3"></i>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-state-icon">
                                            <i class="bi bi-person-x"></i>
                                        </div>
                                        <p class="mb-1 fs-5 fw-semibold text-secondary">Data pengguna tidak ditemukan.</p>
                                        <small class="text-muted">Belum ada user yang cocok dengan pencarian.</small>
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

@endsection