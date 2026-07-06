@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')

@php
    $totalDipinjam = $transaksis
        ->where('status', 'Dipinjam')
        ->count();

    $totalDikembalikan = $transaksis
        ->where('status', 'Dikembalikan')
        ->count();

    $totalTerlambat = $transaksis
        ->filter(fn ($transaksi) =>
            $transaksi->status === 'Dipinjam' &&
            $transaksi->terlambat > 0
        )
        ->count();
@endphp

{{-- Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-arrow-left-right text-primary me-1"></i>
            Data Transaksi
        </h2>

        <p class="text-secondary mb-0">
            Kelola peminjaman dan pengembalian buku.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('laporan.index') }}"
           class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-text me-1"></i>
            Laporan
        </a>

        <a href="{{ route('transaksi.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Pinjam Buku
        </a>

    </div>

</div>

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
                        {{ $transaksis->count() }}
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
                        Sedang Dipinjam
                    </div>

                    <div class="fs-2 fw-bold">
                        {{ $totalDipinjam }}
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
                        {{ $totalDikembalikan }}
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
                        Terlambat
                    </div>

                    <div class="fs-2 fw-bold">
                        {{ $totalTerlambat }}
                    </div>
                </div>

                <i class="bi bi-exclamation-triangle fs-1 opacity-50"></i>

            </div>
        </div>
    </div>

</div>

{{-- Tabel --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">

        <h5 class="fw-bold mb-0">
            Daftar Transaksi
        </h5>

        <span class="badge text-bg-primary">
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
                    <th>Jadwal</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($transaksis as $transaksi)

                    <tr>

                        {{-- Kode dan Tanggal Pinjam --}}
                        <td class="ps-4">
                            <code class="fw-semibold">
                                {{ $transaksi->kode_transaksi }}
                            </code>

                            <div class="text-secondary small mt-1">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $transaksi->tanggal_pinjam->format('d M Y') }}
                            </div>
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

                        {{-- Jadwal --}}
                        <td>
                            <div class="small text-secondary">
                                Batas kembali
                            </div>

                            <div class="fw-semibold">
                                {{ $transaksi->tanggal_kembali->format('d M Y') }}
                            </div>

                            @if($transaksi->tanggal_dikembalikan)
                                <small class="text-success">
                                    Dikembalikan:
                                    {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                                </small>
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
                            @if($transaksi->denda > 0)
                                <span class="fw-bold text-danger">
                                    Rp {{ number_format(
                                        $transaksi->denda,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </span>
                            @else
                                <span class="text-secondary">
                                    -
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center pe-4">

                            <div class="d-inline-flex gap-1">

                                <a href="{{ route('transaksi.show', $transaksi->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if($transaksi->status === 'Dipinjam')

                                    <form
                                        action="{{ route('transaksi.kembalikan', $transaksi->id) }}"
                                        method="POST"
                                        class="form-kembalikan">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-success btn-kembalikan"
                                            title="Kembalikan buku"
                                            data-kode="{{ $transaksi->kode_transaksi }}"
                                            data-buku="{{ $transaksi->buku->judul }}">

                                            <i class="bi bi-arrow-return-left"></i>

                                        </button>

                                    </form>

                                @else

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        title="Transaksi selesai"
                                        disabled>

                                        <i class="bi bi-check2-all"></i>

                                    </button>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7"
                            class="text-center py-5">

                            <i class="bi bi-arrow-left-right display-5 text-secondary"></i>

                            <p class="text-secondary mt-2 mb-3">
                                Belum ada transaksi.
                            </p>

                            <a href="{{ route('transaksi.create') }}"
                               class="btn btn-primary btn-sm">
                                Buat Peminjaman
                            </a>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document
        .querySelectorAll('.btn-kembalikan')
        .forEach(function (button) {
            button.addEventListener('click', function () {
                const form =
                    this.closest('.form-kembalikan');

                const kode =
                    this.dataset.kode;

                const buku =
                    this.dataset.buku;

                Swal.fire({
                    title: 'Konfirmasi Pengembalian',
                    html: `
                        Kembalikan buku
                        <strong>${buku}</strong>?
                        <br>
                        <small class="text-secondary">
                            ${kode}
                        </small>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, kembalikan',
                    cancelButtonText: 'Batal'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
});
</script>
@endpush