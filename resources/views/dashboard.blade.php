@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Dashboard</h2>
        <p class="text-secondary mb-0">
            Ringkasan aktivitas perpustakaan
        </p>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span class="text-secondary">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->translatedFormat('d F Y') }}
        </span>

        <a href="{{ route('transaksi.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Pinjam Buku
        </a>
    </div>
</div>

   {{-- Informasi Data Perpustakaan --}}

    <div class="row g-3 mb-4">

        {{-- Total Buku: Biru --}}
        <div class="col-md-4">
            <div class="card text-bg-primary border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small opacity-75 mb-1">
                            Total Buku
                        </div>

                        <div class="fs-2 fw-bold">
                            {{ $stats['total_buku'] }}
                        </div>

                        <small class="opacity-75">
                            Seluruh koleksi
                        </small>
                    </div>

                    <i class="bi bi-book-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Buku Tersedia: Hijau --}}
        <div class="col-md-4">
            <div class="card text-bg-success border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small opacity-75 mb-1">
                            Buku Tersedia
                        </div>

                        <div class="fs-2 fw-bold">
                            {{ $stats['buku_tersedia'] }}
                        </div>

                        <small class="opacity-75">
                            Siap dipinjam
                        </small>
                    </div>

                    <i class="bi bi-check-circle-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Anggota: Cyan --}}
        <div class="col-md-4">
            <div class="card text-bg-info border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small opacity-75 mb-1">
                            Anggota Aktif
                        </div>

                        <div class="fs-2 fw-bold">
                            {{ $stats['total_anggota'] }}
                        </div>

                        <small class="opacity-75">
                            Pengguna aktif
                        </small>
                    </div>

                    <i class="bi bi-people-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

    </div>

    
    <div class="row g-3 mb-4">

        {{-- Sedang Dipinjam: Kuning --}}
        <div class="col-md-4">
            <div class="card text-bg-warning border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small opacity-75 mb-1">
                            Sedang Dipinjam
                        </div>

                        <div class="fs-2 fw-bold">
                            {{ $stats['sedang_dipinjam'] }}
                        </div>

                        <small class="opacity-75">
                            Belum dikembalikan
                        </small>
                    </div>

                    <i class="bi bi-journal-arrow-up fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Terlambat: Merah --}}
        <div class="col-md-4">
            <div class="card text-bg-danger border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small opacity-75 mb-1">
                            Terlambat
                        </div>

                        <div class="fs-2 fw-bold">
                            {{ $stats['terlambat'] }}
                        </div>

                        <small class="opacity-75">
                            Perlu ditindaklanjuti
                        </small>
                    </div>

                    <i class="bi bi-exclamation-triangle-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Hari Ini: Biru muda --}}
        <div class="col-md-4">
            <div class="card border-primary shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small text-primary mb-1">
                            Transaksi Hari Ini
                        </div>

                        <div class="fs-2 fw-bold text-primary">
                            {{ $stats['transaksi_hari_ini'] }}
                        </div>

                        <small class="text-secondary">
                            Aktivitas terbaru
                        </small>
                    </div>

                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                        <i class="bi bi-calendar-check-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mb-4">

        {{-- Total Transaksi: Gelap --}}
        <div class="col-md-6">
            <div class="card text-bg-dark border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small opacity-75 mb-1">
                            Total Transaksi
                        </div>

                        <div class="fs-2 fw-bold">
                            {{ $stats['total_transaksi'] }}
                        </div>

                        <small class="opacity-75">
                            Seluruh riwayat transaksi
                        </small>
                    </div>

                    <i class="bi bi-receipt-cutoff fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

        {{-- Denda: Ungu --}}
        <div class="col-md-6">
            <div class="card text-white border-0 shadow-sm h-100"
                style="background-color: #6f42c1;">

                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="small opacity-75 mb-1">
                            Denda Bulan Ini
                        </div>

                        <div class="fs-3 fw-bold">
                            Rp {{ number_format(
                                $stats['denda_bulan_ini'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </div>

                        <small class="opacity-75">
                            Total denda diterima
                        </small>
                    </div>

                    <i class="bi bi-cash-coin fs-1 opacity-50"></i>
                </div>
            </div>
        </div>

    </div>
    {{-- Charts --}}
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary-subtle text-primary-emphasis">
                    <strong>
                        <i class="bi bi-graph-up me-1"></i>
                        Transaksi 6 Bulan Terakhir
                    </strong>
                </div>

                <div class="card-body">
                    <canvas id="chartTransaksi" height="110"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-success-subtle text-success-emphasis">
                    <strong>
                        <i class="bi bi-pie-chart me-1"></i>
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <strong>
                        <i class="bi bi-bookmark-star"></i>
                        Top 5 Buku Populer
                    </strong>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info-subtle text-info-emphasis">
                    <strong>
                        <i class="bi bi-person-check me-1"></i>
                        Top 5 Anggota Aktif
                    </strong>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
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

    {{-- Daftar Buku Terlambat --}}
    <div class="card border-danger shadow-sm mb-4">

        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <strong>
                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                Buku Terlambat
            </strong>

            <span class="badge bg-light text-danger">
                {{ $bukuTerlambat->count() }} transaksi
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Anggota</th>
                        <th>Buku</th>
                        <th>Batas Kembali</th>
                        <th>Keterlambatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bukuTerlambat as $transaksi)
                        <tr>
                            <td class="ps-3">
                                <div class="fw-semibold">
                                    {{ $transaksi->anggota?->nama ?? '-' }}
                                </div>

                                <small class="text-secondary">
                                    {{ $transaksi->anggota?->kode_anggota ?? '-' }}
                                </small>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $transaksi->buku?->judul ?? '-' }}
                                </div>

                                <small class="text-secondary">
                                    {{ $transaksi->kode_transaksi }}
                                </small>
                            </td>

                            <td>
                                {{ $transaksi->tanggal_kembali->format('d M Y') }}
                            </td>

                            <td>
                                <span class="badge text-bg-danger">
                                    Terlambat {{ $transaksi->terlambat }} hari
                                </span>

                                <div class="small text-danger mt-1">
                                    Estimasi denda:
                                    Rp {{ number_format(
                                        $transaksi->terlambat * 5000,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </div>
                            </td>

                            <td class="text-center">
                                <a
                                    href="{{ route('transaksi.show', $transaksi->id) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="Lihat transaksi">

                                    <i class="bi bi-eye"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="bi bi-check-circle-fill text-success fs-3"></i>

                                <p class="text-secondary mb-0 mt-2">
                                    Tidak ada buku yang terlambat dikembalikan.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- Recent Transactions --}}
    <div class="card shadow-sm">
        <div class="card-header bg-warning-subtle text-warning-emphasis">
            <strong>
                <i class="bi bi-clock-history me-1"></i>
                Transaksi Terbaru
            </strong>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle mb-0">
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


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartTransaksiElement =
        document.getElementById('chartTransaksi');

    if (chartTransaksiElement) {
        new Chart(chartTransaksiElement, {
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
                maintainAspectRatio: true,

                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    @if($bukuPopuler->sum('transaksis_count') > 0)
        const chartBukuElement =
            document.getElementById('chartBuku');

        if (chartBukuElement) {
            new Chart(chartBukuElement, {
                type: 'doughnut',

                data: {
                    labels: @json($bukuPopuler->pluck('judul')),

                    datasets: [{
                        data: @json(
                            $bukuPopuler->pluck('transaksis_count')
                        ),

                        backgroundColor: [
                            '#0d6efd',
                            '#198754',
                            '#ffc107',
                            '#dc3545',
                            '#6f42c1'
                        ],

                        borderWidth: 0
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
        }
    @endif
});
</script>
@endpush