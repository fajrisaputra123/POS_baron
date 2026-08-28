<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">POS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/produk*') ? 'active' : '' }}" href="{{ route('admin.produk.index') }}">Produk</a>
        </li>
        <!-- Perbaikan: Penambahan tag <li class="nav-item"> dan proteksi nama route -->
        <li class="nav-item">
          <a class="nav-link {{ Request::is('penjualan*') || Request::is('admin/penjualan*') ? 'active' : '' }}" 
             href="{{ Route::has('penjualan.index') ? route('penjualan.index') : (Route::has('admin.penjualan.index') ? route('admin.penjualan.index') : (Route::has('penjualan.create') ? route('penjualan.create') : '#')) }}">
             Penjualan
          </a>
        </li>
      </ul>
      <form class="ms-auto" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger me-2">Logout</button>
      </form>
    </div>
  </div>
</nav>