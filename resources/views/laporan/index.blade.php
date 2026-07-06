@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')

{{-- Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 d-print-none">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-file-earmark-bar-graph text-primary me-1"></i>
            Laporan Transaksi
        </h2>

        <p class="text-secondary mb-0">
            Filter, cetak, dan ekspor data transaksi perpustakaan.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('laporan.pdf', request()->query()) }}"
           class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf me-1"></i>
            Export PDF
        </a>

    </div>

</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-4 d-print-none">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-funnel text-primary me-1"></i>
            Filter Laporan
        </h5>
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <div class="fw-semibold mb-1">Filter laporan belum valid:</div>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('laporan.index') }}"
              method="GET">

            <div class="row g-3">

                <div class="col-md-6 col-xl-3">
                    <label for="dari"
                           class="form-label">
                        Dari Tanggal
                    </label>

                    <input
                        id="dari"
                        type="date"
                        name="dari"
                        class="form-control"
                        value="{{ request('dari') }}">
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="sampai"
                           class="form-label">
                        Sampai Tanggal
                    </label>

                    <input
                        id="sampai"
                        type="date"
                        name="sampai"
                        class="form-control"
                        value="{{ request('sampai') }}">
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="status"
                           class="form-label">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="Dipinjam"
                            {{ request('status') === 'Dipinjam' ? 'selected' : '' }}>
                            Dipinjam
                        </option>

                        <option value="Dikembalikan"
                            {{ request('status') === 'Dikembalikan' ? 'selected' : '' }}>
                            Dikembalikan
                        </option>

                    </select>
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="anggota_id"
                           class="form-label">
                        Anggota
                    </label>

                    <select
                        id="anggota_id"
                        name="anggota_id"
                        class="form-select">

                        <option value="">
                            Semua Anggota
                        </option>

                        @foreach($anggotas as $anggota)
                            <option
                                value="{{ $anggota->id }}"
                                {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>

                                {{ $anggota->nama }}

                            </option>
                        @endforeach

                    </select>
                </div>

            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">

                <button type="submit"
                        class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>
                    Tampilkan
                </button>

                <a href="{{ route('laporan.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Reset
                </a>

            </div>

        </form>

    </div>

</div>

{{-- Statistik --}}
<div class="row g-3 mb-4">

    <div class="col-sm-6 col-xl-3">
        <div class="card text-bg-primary border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="small opacity-75">
                        Total Transaksi
                    </div>

                    <div class="fs-2 fw-bold">
                        {{ $summary['total'] }}
                    </div>
                </div>

                <i class="bi bi-receipt fs-1 opacity-50"></i>

            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card text-bg-warning border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="small opacity-75">
                        Dipinjam
                    </div>

                    <div class="fs-2 fw-bold">
                        {{ $summary['dipinjam'] }}
                    </div>
                </div>

                <i class="bi bi-journal-arrow-up fs-1 opacity-50"></i>

            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card text-bg-success border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="small opacity-75">
                        Dikembalikan
                    </div>

                    <div class="fs-2 fw-bold">
                        {{ $summary['dikembalikan'] }}
                    </div>
                </div>

                <i class="bi bi-check-circle fs-1 opacity-50"></i>

            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card text-bg-danger border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="small opacity-75">
                        Total Denda
                    </div>

                    <div class="fs-5 fw-bold">
                        Rp {{ number_format(
                            $summary['total_denda'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </div>
                </div>

                <i class="bi bi-cash-coin fs-1 opacity-50"></i>

            </div>
        </div>
    </div>

</div>

{{-- Tabel --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">

        <h5 class="fw-bold mb-0">
            Data Laporan
        </h5>

        <span class="badge text-bg-primary d-print-none">
            {{ $transaksis->count() }} data
        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th class="ps-4">Transaksi</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transaksis as $transaksi)

                    <tr>

                        {{-- Transaksi --}}
                        <td class="ps-4">
                            <code class="fw-semibold">
                                {{ $transaksi->kode_transaksi }}
                            </code>
                        </td>

                        {{-- Anggota --}}
                        <td>
                            <div class="fw-semibold">
                                {{ $transaksi->anggota->nama }}
                            </div>

                            <small class="text-secondary">
                                {{ $transaksi->anggota->kode_anggota }}
                            </small>
                        </td>

                        {{-- Buku --}}
                        <td>
                            <div class="fw-semibold">
                                {{ $transaksi->buku->judul }}
                            </div>

                            <small class="text-secondary">
                                {{ $transaksi->buku->kode_buku }}
                            </small>
                        </td>

                        {{-- Tanggal --}}
                        <td>
                            <div>
                                <span class="text-secondary small">
                                    Pinjam:
                                </span>

                                {{ $transaksi->tanggal_pinjam->format('d M Y') }}
                            </div>

                            <div>
                                <span class="text-secondary small">
                                    Batas:
                                </span>

                                {{ $transaksi->tanggal_kembali->format('d M Y') }}
                            </div>

                            @if($transaksi->tanggal_dikembalikan)
                                <div class="text-success small">
                                    Kembali:
                                    {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                                </div>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($transaksi->status === 'Dipinjam')
                                <span class="badge text-bg-warning">
                                    Dipinjam
                                </span>

                                @if($transaksi->terlambat > 0)
                                    <div class="mt-1">
                                        <span class="badge text-bg-danger">
                                            Terlambat
                                            {{ $transaksi->terlambat }} hari
                                        </span>
                                    </div>
                                @endif
                            @else
                                <span class="badge text-bg-success">
                                    Dikembalikan
                                </span>
                            @endif
                        </td>

                        {{-- Denda --}}
                        <td>
                            @php
                                $dendaDitampilkan =
                                    $transaksi->status === 'Dipinjam'
                                        ? $transaksi->terlambat * 5000
                                        : $transaksi->denda;
                            @endphp

                            @if($dendaDitampilkan > 0)
                                <div class="fw-bold text-danger">
                                    Rp {{ number_format(
                                        $dendaDitampilkan,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </div>

                                @if($transaksi->status === 'Dipinjam')
                                    <small class="text-secondary">
                                        Estimasi
                                    </small>
                                @endif
                            @else
                                <span class="text-secondary">
                                    -
                                </span>
                            @endif
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6"
                            class="text-center py-5">

                            <i class="bi bi-file-earmark-text display-5 text-secondary"></i>

                            <p class="text-secondary mt-2 mb-0">
                                Tidak ada data transaksi sesuai filter.
                            </p>

                        </td>
                    </tr>

                @endforelse

            </tbody>

            @if($transaksis->isNotEmpty())
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5"
                            class="text-end">
                            Total Denda
                        </th>

                        <th class="text-danger">
                            Rp {{ number_format(
                                $summary['total_denda'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </th>
                    </tr>
                </tfoot>
            @endif

        </table>

    </div>

</div>

@endsection