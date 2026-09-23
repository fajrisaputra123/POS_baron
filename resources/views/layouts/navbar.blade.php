<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #121212;">
  <div class="container-fluid">
    <a class="navbar-brand text-white fw-bold fs-4 me-4" href="#">POS fajri</a>
    <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('dashboard') ? 'fw-bold border-bottom border-2 border-white' : 'opacity-75' }}" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('admin/users*') ? 'fw-bold border-bottom border-2 border-white' : 'opacity-75' }}" href="{{ route('admin.users') }}">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('jenis*') ? 'fw-bold border-bottom border-2 border-white' : 'opacity-75' }}" href="{{ route('jenis.index') }}">Jenis</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('produk*') ? 'fw-bold border-bottom border-2 border-white' : 'opacity-75' }}" href="{{ route('produk.index') }}">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('penjualan*') ? 'fw-bold border-bottom border-2 border-white' : 'opacity-75' }}" href="{{ route('penjualan.index') }}">Penjualan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('laporan-penjualan*') ? 'fw-bold border-bottom border-2 border-white' : 'opacity-75' }}" href="{{ route('laporan.penjualan') }}">Laporan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ Request::is('tentang*') ? 'fw-bold border-bottom border-2 border-white' : 'opacity-75' }}" href="{{ route('tentang') }}">Tentang</a>
        </li>
      </ul>
      
      <form class="ms-auto" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger fw-semibold px-3 shadow-sm">Logout</button>
      </form>
    </div>
  </div>
</nav>