{{-- Header Mobile --}}
<nav class="navbar navbar-dark bg-dark d-lg-none sticky-top shadow-sm">
    <div class="container-fluid">

        <a href="{{ route('dashboard') }}"
           class="navbar-brand fw-semibold">
            <i class="bi bi-book-half me-2"></i>
            Perpustakaan
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#adminSidebar"
                aria-controls="adminSidebar">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>

{{-- Sidebar --}}
<aside class="offcanvas-lg offcanvas-start text-bg-dark flex-shrink-0"
       tabindex="-1"
       id="adminSidebar"
       style="width: 280px;"
       aria-labelledby="adminSidebarLabel">

    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title fw-bold"
            id="adminSidebarLabel">
            <i class="bi bi-book-half text-primary me-2"></i>
            Perpustakaan
        </h5>

        <button type="button"
                class="btn-close btn-close-white d-lg-none"
                data-bs-dismiss="offcanvas"
                data-bs-target="#adminSidebar"
                aria-label="Tutup">
        </button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-3 overflow-auto">

        {{-- Pencarian --}}
        <form action="{{ route('search') }}"
              method="GET"
              class="mb-4">

            <div class="input-group">
                <span class="input-group-text bg-dark border-secondary text-secondary">
                    <i class="bi bi-search"></i>
                </span>

                <input type="search"
                       name="q"
                       class="form-control bg-dark border-secondary text-white"
                       placeholder="Cari data..."
                       value="{{ request('q') }}">
            </div>

        </form>

        {{-- Menu Utama --}}
        <small class="text-secondary text-uppercase fw-semibold px-2 mb-2">
            Utama
        </small>

        <ul class="nav nav-pills flex-column gap-1 mb-4">

            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-white-50' }}">
                    <i class="bi bi-grid me-2"></i>
                    Dashboard
                </a>
            </li>

        </ul>

        {{-- Menu Data --}}
        <small class="text-secondary text-uppercase fw-semibold px-2 mb-2">
            Data
        </small>

        <ul class="nav nav-pills flex-column gap-1 mb-4">

            <li class="nav-item">
                <a href="{{ route('buku.index') }}"
                   class="nav-link {{ request()->routeIs('buku.*') ? 'active' : 'text-white-50' }}">
                    <i class="bi bi-book me-2"></i>
                    Data Buku
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('anggota.index') }}"
                   class="nav-link {{ request()->routeIs('anggota.*') ? 'active' : 'text-white-50' }}">
                    <i class="bi bi-people me-2"></i>
                    Data Anggota
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('transaksi.index') }}"
                   class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : 'text-white-50' }}">
                    <i class="bi bi-arrow-left-right me-2"></i>
                    Transaksi
                </a>
            </li>

        </ul>

        {{-- Menu Laporan --}}
        <small class="text-secondary text-uppercase fw-semibold px-2 mb-2">
            Laporan
        </small>

        <ul class="nav nav-pills flex-column gap-1 mb-4">

            <li class="nav-item">
                <a href="{{ route('laporan.index') }}"
                   class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : 'text-white-50' }}">
                    <i class="bi bi-file-earmark-bar-graph me-2"></i>
                    Laporan Transaksi
                </a>
            </li>

        </ul>

        {{-- Bagian Bawah --}}
        <div class="mt-auto pt-3 border-top border-secondary">

            <div class="d-flex align-items-center mb-3 px-2">

                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2"
                     style="width: 40px; height: 40px;">
                    <span class="fw-bold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>

                <div class="overflow-hidden">
                    <div class="fw-semibold text-white text-truncate">
                        {{ Auth::user()->name }}
                    </div>

                    <small class="text-secondary d-block text-truncate">
                        {{ Auth::user()->email }}
                    </small>
                </div>

            </div>

            <a href="{{ route('profile.edit') }}"
               class="btn btn-outline-light w-100 text-start mb-2">
                <i class="bi bi-gear me-2"></i>
                Pengaturan
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="btn btn-outline-danger w-100 text-start">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </button>
            </form>

        </div>

    </div>
</aside>