@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-file-earmark-text"></i>
            Laporan Transaksi
        </h1>

        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-funnel"></i>
                Filter Laporan
            </h5>
        </div>

        <div class="card-body">
            <form action="{{ route('transaksi.laporan') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="dari" class="form-label">Dari Tanggal</label>
                        <input type="date" 
                               name="dari" 
                               id="dari" 
                               class="form-control"
                               value="{{ request('dari') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="sampai" class="form-label">Sampai Tanggal</label>
                        <input type="date" 
                               name="sampai" 
                               id="sampai" 
                               class="form-control"
                               value="{{ request('sampai') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua</option>
                            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="anggota_id" class="form-label">Anggota</label>
                        <select name="anggota_id" id="anggota_id" class="form-select">
                            <option value="">Semua Anggota</option>
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>

                    <a href="{{ route('transaksi.laporan') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>

                    <a href="{{ route('transaksi.laporan.pdf', request()->query()) }}" 
                       class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Transaksi</h6>
                    <h2 class="mb-0">{{ $totalTransaksi }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-danger shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Denda</h6>
                    <h2 class="mb-0">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-table"></i>
                Data Laporan Transaksi
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Tanggal Dikembalikan</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transaksis as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                                <td>{{ $transaksi->anggota->nama }}</td>
                                <td>{{ $transaksi->buku->judul }}</td>
                                <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                                <td>
                                    @if($transaksi->tanggal_dikembalikan)
                                        {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                                    @else
                                        <span class="text-muted">Belum dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($transaksi->status == 'Dipinjam')
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @else
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @endif
                                </td>
                                <td>
                                    Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    Tidak ada data transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="8" class="text-end">Total Denda</th>
                            <th>
                                Rp {{ number_format($totalDenda, 0, ',', '.') }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection