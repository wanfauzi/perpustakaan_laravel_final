<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="bi bi-book-fill"></i>
            Perpustakaan
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">

            {{-- Menu Kiri --}}
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('buku*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                        <i class="bi bi-book"></i> Buku
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('anggota*') ? 'active' : '' }}" href="{{ route('anggota.index') }}">
                        <i class="bi bi-people"></i> Anggota
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('transaksi') || Request::is('transaksi/*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                        <i class="bi bi-arrow-left-right"></i> Transaksi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('laporan') ? 'active' : '' }}" href="{{ laporan.index') }}">
                        <i class="bi bi-file-earmark-text"></i> Laporan
                    </a>
                </li>
            </ul>

            {{-- Search Box --}}
            <form class="d-flex mt-3 mt-lg-0" action="{{ route('search') }}" method="GET">
                <input class="form-control me-2"
                       type="search"
                       name="q"
                       placeholder="Cari..."
                       value="{{ request('q') }}"
                       aria-label="Search">

                <button class="btn btn-outline-light" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>
</nav>