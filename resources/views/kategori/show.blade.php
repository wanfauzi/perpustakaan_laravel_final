@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            {{ $kategori->nama_kategori }}
        </h2>

        <p class="text-secondary mb-0">
            {{ $kategori->deskripsi ?: 'Tidak ada deskripsi.' }}
        </p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('kategori.edit', $kategori->id) }}"
           class="btn btn-warning">

            <i class="bi bi-pencil me-1"></i>
            Edit
        </a>

        <a href="{{ route('kategori.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3 d-flex justify-content-between">
        <h5 class="fw-bold mb-0">
            Buku dalam Kategori
        </h5>

        <span class="badge text-bg-primary">
            {{ $kategori->bukus->count() }} buku
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th class="ps-3">Kode</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kategori->bukus as $buku)
                    <tr>
                        <td class="ps-3">
                            <code>{{ $buku->kode_buku }}</code>
                        </td>

                        <td class="fw-semibold">
                            {{ $buku->judul }}
                        </td>

                        <td>
                            {{ $buku->pengarang }}
                        </td>

                        <td>
                            <span class="badge {{ $buku->stok > 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                                {{ $buku->stok }}
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('buku.show', $buku->id) }}"
                               class="btn btn-sm btn-outline-primary">

                                <i class="bi bi-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="text-center text-secondary py-4">

                            Belum ada buku dalam kategori ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection