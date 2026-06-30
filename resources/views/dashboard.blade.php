@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-speedometer2"></i>
            Dashboard Perpustakaan
        </h2>

        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Pinjam Buku
        </a>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        @foreach([
            ['Total Buku', $stats['total_buku'], 'bi-book', 'primary'],
            ['Anggota Aktif', $stats['total_anggota'], 'bi-people', 'success'],
            ['Sedang Dipinjam', $stats['sedang_dipinjam'], 'bi-journal-arrow-up', 'info'],
            ['Terlambat', $stats['terlambat'], 'bi-exclamation-triangle', 'danger'],
            ['Transaksi Hari Ini', $stats['transaksi_hari_ini'], 'bi-calendar-check', 'warning'],
            ['Buku Tersedia', $stats['buku_tersedia'], 'bi-bookshelf', 'secondary'],
            ['Total Transaksi', $stats['total_transaksi'], 'bi-receipt', 'dark'],
            ['Denda Bulan Ini', 'Rp ' . number_format($stats['denda_bulan_ini'], 0, ',', '.'), 'bi-cash', 'danger'],
        ] as [$label, $value, $icon, $color])
            <div class="col-xl-3 col-md-6">
                <div class="card border-{{ $color }} h-100 shadow-sm">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi {{ $icon }} fs-1 text-{{ $color }} me-3"></i>

                        <div>
                            <h6 class="text-muted mb-1">{{ $label }}</h6>
                            <h4 class="mb-0">{{ $value }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <strong>
                        <i class="bi bi-graph-up"></i>
                        Transaksi 6 Bulan Terakhir
                    </strong>
                </div>

                <div class="card-body">
                    <canvas id="chartTransaksi" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <strong>
                        <i class="bi bi-pie-chart"></i>
                        Top 5 Buku Populer
                    </strong>
                </div>

                <div class="card-body">
                    @if($bukuPopuler->sum('transaksis_count') > 0)
                        <canvas id="chartBuku" height="220"></canvas>
                    @else
                        <div class="alert alert-info mb-0">
                            Belum ada data peminjaman buku.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Top Buku dan Top Anggota --}}
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <strong>
                        <i class="bi bi-bookmark-star"></i>
                        Top 5 Buku Populer
                    </strong>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Total Dipinjam</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($bukuPopuler as $buku)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $buku->judul }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $buku->transaksis_count }} kali
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            Belum ada data buku populer
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <strong>
                        <i class="bi bi-person-check"></i>
                        Top 5 Anggota Aktif
                    </strong>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Total Transaksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($anggotaAktif as $anggota)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $anggota->nama }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $anggota->transaksis_count }} transaksi
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            Belum ada data anggota aktif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Recent Transactions --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <strong>
                <i class="bi bi-clock-history"></i>
                Transaksi Terbaru
            </strong>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentTransaksi as $trx)
                        <tr>
                            <td>
                                <code>{{ $trx->kode_transaksi }}</code>
                            </td>

                            <td>{{ $trx->anggota->nama }}</td>

                            <td>{{ $trx->buku->judul }}</td>

                            <td>{{ $trx->tanggal_pinjam->format('d/m/Y') }}</td>

                            <td>
                                @if($trx->status === 'Dipinjam')
                                    <span class="badge bg-warning text-dark">
                                        Dipinjam
                                    </span>

                                    @if($trx->tanggal_kembali < today())
                                        <span class="badge bg-danger">
                                            Terlambat
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-success">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada transaksi terbaru
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Line chart — Transaksi 6 bulan terakhir
    new Chart(document.getElementById('chartTransaksi'), {
        type: 'line',
        data: {
            labels: @json($chartData->pluck('bulan')),
            datasets: [
                {
                    label: 'Peminjaman',
                    data: @json($chartData->pluck('pinjam')),
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Pengembalian',
                    data: @json($chartData->pluck('kembali')),
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    @if($bukuPopuler->sum('transaksis_count') > 0)
        // Pie chart — Top 5 buku populer
        new Chart(document.getElementById('chartBuku'), {
            type: 'pie',
            data: {
                labels: @json($bukuPopuler->pluck('judul')),
                datasets: [{
                    data: @json($bukuPopuler->pluck('transaksis_count')),
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#ffc107',
                        '#dc3545',
                        '#6f42c1'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    @endif
</script>

@endsection