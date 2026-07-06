@extends('layouts.app')

@section('title', $buku->judul)

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
            <a href="{{ route('buku.index') }}"
               class="text-decoration-none">
                Data Buku
            </a>
        </li>

        <li class="breadcrumb-item active">
            Detail
        </li>

    </ol>
</nav>

{{-- Pesan --}}
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

    {{-- Informasi Utama --}}
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            {{-- Header Buku --}}
            <div class="card-body p-4">

                <div class="d-flex flex-column flex-sm-row gap-4">

                    {{-- Icon Buku --}}
                    <div class="flex-shrink-0">

                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center"
                             style="width: 110px; height: 140px;">

                            <i class="bi bi-book-half display-3"></i>

                        </div>

                    </div>

                    {{-- Identitas --}}
                    <div class="flex-grow-1">

                        <div class="d-flex flex-wrap gap-2 mb-2">

                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-tag me-1"></i>
                                {{ $buku->kategori }}
                            </span>

                            @if($buku->stok > 5)
                                <span class="badge text-bg-success">
                                    Tersedia
                                </span>
                            @elseif($buku->stok > 0)
                                <span class="badge text-bg-warning">
                                    Stok Menipis
                                </span>
                            @else
                                <span class="badge text-bg-danger">
                                    Stok Habis
                                </span>
                            @endif

                        </div>

                        <h2 class="fw-bold mb-2">
                            {{ $buku->judul }}
                        </h2>

                        <p class="text-secondary mb-3">
                            <i class="bi bi-person me-1"></i>
                            {{ $buku->pengarang }}
                        </p>

                        <div class="fs-4 fw-bold text-primary">
                            {{ $buku->harga_format }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- Detail Buku --}}
            <div class="card-body border-top p-4">

                <h5 class="fw-bold mb-3">
                    Informasi Buku
                </h5>

                <div class="row g-3">

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Kode Buku
                        </div>

                        <div class="fw-semibold">
                            {{ $buku->kode_buku }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            ISBN
                        </div>

                        <div class="fw-semibold">
                            {{ $buku->isbn ?: '-' }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Penerbit
                        </div>

                        <div class="fw-semibold">
                            {{ $buku->penerbit }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Tahun Terbit
                        </div>

                        <div class="fw-semibold">
                            {{ $buku->tahun_terbit }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Bahasa
                        </div>

                        <div class="fw-semibold">
                            {{ $buku->bahasa }}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="text-secondary small">
                            Stok
                        </div>

                        <div class="fw-semibold">
                            {{ $buku->stok }} buku
                        </div>
                    </div>

                </div>

            </div>

            {{-- Deskripsi --}}
            <div class="card-body border-top p-4">

                <h5 class="fw-bold mb-3">
                    Deskripsi
                </h5>

                @if($buku->deskripsi)
                    <p class="text-secondary lh-lg mb-0">
                        {{ $buku->deskripsi }}
                    </p>
                @else
                    <p class="text-secondary fst-italic mb-0">
                        Belum ada deskripsi untuk buku ini.
                    </p>
                @endif

            </div>

        </div>

    </div>

    {{-- Sidebar Aksi --}}
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white p-3">
                <h5 class="fw-bold mb-0">
                    Aksi
                </h5>
            </div>

            <div class="card-body d-grid gap-2">

                <a href="{{ route('buku.edit', $buku->id) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil me-1"></i>
                    Edit Buku
                </a>

                <a href="{{ route('buku.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

                <form action="{{ route('buku.destroy', $buku->id) }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus buku ini?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-1"></i>
                        Hapus Buku
                    </button>

                </form>

            </div>

        </div>

        {{-- Informasi Sistem --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white p-3">
                <h5 class="fw-bold mb-0">
                    Informasi Data
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <div class="text-secondary small">
                        Ditambahkan
                    </div>

                    <div>
                        {{ $buku->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                    </div>
                </div>

                <div>
                    <div class="text-secondary small">
                        Terakhir diperbarui
                    </div>

                    <div>
                        {{ $buku->updated_at->copy()->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- Buku Serupa --}}
@php
    $daftarBukuSerupa = $bukuSerupa ?? collect();
@endphp

@if($daftarBukuSerupa->isNotEmpty())

    <div class="mt-4">

        <h5 class="fw-bold mb-3">
            Buku Lain dalam Kategori yang Sama
        </h5>

        <div class="row g-3">

            @foreach($daftarBukuSerupa as $item)

                <div class="col-md-6 col-xl-4">

                    <a href="{{ route('buku.show', $item->id) }}"
                       class="text-decoration-none">

                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">

                                <span class="badge bg-light text-dark border mb-2">
                                    {{ $item->kategori }}
                                </span>

                                <h6 class="fw-bold text-dark mb-1">
                                    {{ $item->judul }}
                                </h6>

                                <p class="text-secondary small mb-0">
                                    {{ $item->pengarang }}
                                </p>

                            </div>
                        </div>

                    </a>

                </div>

            @endforeach

        </div>

    </div>

@endif

@endsection