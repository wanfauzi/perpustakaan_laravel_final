@extends('layouts.app')

@section('title', 'Kategori Buku')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-tags text-primary me-1"></i>
            Kategori Buku
        </h2>

        <p class="text-secondary mb-0">
            Kelola kategori koleksi buku.
        </p>
    </div>

    <div>
        <a href="{{ route('kategori.create') }}"
           class="btn btn-primary">

            <i class="bi bi-plus-lg me-1"></i>
            Tambah Kategori
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <form action="{{ route('kategori.index') }}"
              method="GET">

            <div class="row g-2">
                <div class="col-md-10">
                    <input
                        type="search"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        class="form-control"
                        placeholder="Cari nama atau deskripsi kategori">
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit"
                            class="btn btn-primary">

                        <i class="bi bi-search me-1"></i>
                        Cari
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3 d-flex justify-content-between">
        <h5 class="fw-bold mb-0">
            Daftar Kategori
        </h5>

        <span class="badge text-bg-primary">
            {{ $kategoris->count() }} kategori
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th class="ps-3">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Buku</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kategoris as $kategori)
                    <tr>
                        <td class="ps-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="fw-semibold">
                            {{ $kategori->nama_kategori }}
                        </td>

                        <td>
                            {{ $kategori->deskripsi ?: '-' }}
                        </td>

                        <td>
                            <span class="badge text-bg-info">
                                {{ $kategori->bukus_count }} buku
                            </span>
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-1">

                                <a
                                    href="{{ route('kategori.show', $kategori->id) }}"
                                    class="btn btn-sm btn-outline-primary"
                                    title="Detail">

                                    <i class="bi bi-eye"></i>
                                </a>

                                <a
                                    href="{{ route('kategori.edit', $kategori->id) }}"
                                    class="btn btn-sm btn-outline-warning"
                                    title="Edit">

                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form
                                    action="{{ route('kategori.destroy', $kategori->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Hapus">

                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="text-center text-secondary py-5">

                            <i class="bi bi-tags fs-1"></i>

                            <p class="mb-0 mt-2">
                                Belum ada kategori.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection