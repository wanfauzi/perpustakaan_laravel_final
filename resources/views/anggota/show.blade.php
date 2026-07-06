@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')

{{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb mb-0">

        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}"
               class="text-decoration-none">
                Dashboard
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('anggota.index') }}"
               class="text-decoration-none">
                Data Anggota
            </a>
        </li>

        <li class="breadcrumb-item active">
            Detail
        </li>

    </ol>
</nav>

{{-- Alert --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-circle me-1"></i>
        {{ session('error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>
    </div>
@endif

<div class="row g-4">

    {{-- Detail Utama --}}
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            {{-- Profil --}}
            <div class="card-body p-4">

                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3">

                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width: 80px; height: 80px;">

                        <span class="fs-2 fw-bold">
                            {{ strtoupper(substr($anggota->nama, 0, 1)) }}
                        </span>

                    </div>

                    <div class="flex-grow-1">

                        <div class="d-flex flex-wrap gap-2 mb-2">

                            <span class="badge bg-light text-dark border">
                                {{ $anggota->kode_anggota }}
                            </span>

                            @if($anggota->status === 'Aktif')
                                <span class="badge text-bg-success">
                                    Aktif
                                </span>
                            @else
                                <span class="badge text-bg-secondary">
                                    Nonaktif
                                </span>
                            @endif

                        </div>

                        <h2 class="fw-bold mb-1">
                            {{ $anggota->nama }}
                        </h2>

                        <p class="text-secondary mb-0">
                            <i class="bi bi-envelope me-1"></i>
                            {{ $anggota->email }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- Informasi Pribadi --}}
            <div class="card-body border-top p-4">

                <h5 class="fw-bold mb-4">
                    Informasi Anggota
                </h5>

                <div class="row g-4">

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Nomor Telepon
                        </div>

                        <div class="fw-semibold">
                            <i class="bi bi-telephone me-1 text-primary"></i>
                            {{ $anggota->telepon }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Jenis Kelamin
                        </div>

                        <div class="fw-semibold">
                            {{ $anggota->jenis_kelamin }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Tanggal Lahir
                        </div>

                        <div class="fw-semibold">
                            {{ $anggota->tanggal_lahir->format('d M Y') }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Umur
                        </div>

                        <div class="fw-semibold">
                            {{ $anggota->umur }} tahun
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Pekerjaan
                        </div>

                        <div class="fw-semibold">
                            {{ $anggota->pekerjaan ?: '-' }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Tanggal Daftar
                        </div>

                        <div class="fw-semibold">
                            {{ $anggota->tanggal_daftar->format('d M Y') }}
                        </div>
                    </div>

                </div>

            </div>

            {{-- Alamat --}}
            <div class="card-body border-top p-4">

                <h5 class="fw-bold mb-3">
                    Alamat
                </h5>

                <p class="text-secondary mb-0">
                    <i class="bi bi-geo-alt me-1 text-danger"></i>
                    {{ $anggota->alamat }}
                </p>

            </div>

        </div>

    </div>

    {{-- Aksi dan Informasi Sistem --}}
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    Aksi
                </h5>
            </div>

            <div class="card-body d-grid gap-2">

                <a href="{{ route('anggota.edit', $anggota->id) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Anggota
                </a>

                <a href="{{ route('anggota.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

                <form action="{{ route('anggota.destroy', $anggota->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus anggota {{ $anggota->nama }}?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-1"></i>
                        Hapus Anggota
                    </button>

                </form>

            </div>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    Informasi Data
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <div class="text-secondary small">
                        Data dibuat
                    </div>

                    <div class="fw-semibold">
                        {{ $anggota->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                    </div>
                </div>

                <div>
                    <div class="text-secondary small">
                        Terakhir diperbarui
                    </div>

                    <div class="fw-semibold">
                        {{ $anggota->updated_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                    </div>
                </div>

            </div>

        </div>
        
    </div>
    {{-- Statistik Peminjaman --}}
<div class="row g-3 mt-1 mb-4">

    <div class="col-md-4">
        <div class="card text-bg-primary border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="small opacity-75">Total Peminjaman</div>

                <div class="fs-3 fw-bold">
                    {{ $totalPinjam }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-warning border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="small opacity-75">Sedang Dipinjam</div>

                <div class="fs-3 fw-bold">
                    {{ $sedangDipinjam }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-danger border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="small opacity-75">Total Denda</div>

                <div class="fs-4 fw-bold">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Riwayat Peminjaman --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">

            <h5 class="fw-bold mb-0">
                <i class="bi bi-clock-history text-primary me-1"></i>
                Riwayat Peminjaman
            </h5>

            <form method="GET"
                  action="{{ route('anggota.show', $anggota->id) }}"
                  class="d-flex gap-2">

                <select name="status"
                        class="form-select form-select-sm">

                    <option value="">Semua Status</option>

                    <option value="Dipinjam"
                        {{ request('status') === 'Dipinjam' ? 'selected' : '' }}>
                        Dipinjam
                    </option>

                    <option value="Dikembalikan"
                        {{ request('status') === 'Dikembalikan' ? 'selected' : '' }}>
                        Dikembalikan
                    </option>
                </select>

                <button type="submit"
                        class="btn btn-primary btn-sm">
                    Filter
                </button>

                @if(request('status'))
                    <a href="{{ route('anggota.show', $anggota->id) }}"
                       class="btn btn-outline-secondary btn-sm">
                        Reset
                    </a>
                @endif
            </form>

        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th class="ps-3">Transaksi</th>
                    <th>Buku</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($riwayat as $transaksi)
                    <tr>
                        <td class="ps-3">
                            <code>
                                {{ $transaksi->kode_transaksi }}
                            </code>
                        </td>

                        <td>
                            <div class="fw-semibold">
                                {{ $transaksi->buku?->judul ?? '-' }}
                            </div>

                            <small class="text-secondary">
                                {{ $transaksi->buku?->kode_buku ?? '-' }}
                            </small>
                        </td>

                        <td>
                            <div>
                                Pinjam:
                                {{ $transaksi->tanggal_pinjam->format('d M Y') }}
                            </div>

                            <small class="text-secondary">
                                Batas:
                                {{ $transaksi->tanggal_kembali->format('d M Y') }}
                            </small>
                        </td>

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

                        <td>
                            @if($transaksi->denda > 0)
                                <span class="fw-semibold text-danger">
                                    Rp {{ number_format(
                                        $transaksi->denda,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </span>
                            @else
                                <span class="text-secondary">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a
                                href="{{ route('transaksi.show', $transaksi->id) }}"
                                class="btn btn-sm btn-outline-primary">

                                <i class="bi bi-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
                            class="text-center text-secondary py-4">

                            Tidak ada riwayat peminjaman sesuai filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection