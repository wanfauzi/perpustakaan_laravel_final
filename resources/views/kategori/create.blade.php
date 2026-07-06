@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    Tambah Kategori
                </h2>

                <p class="text-secondary mb-0">
                    Tambahkan kategori baru untuk data buku.
                </p>
            </div>

            <a href="{{ route('kategori.index') }}"
               class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <form
                    action="{{ route('kategori.store') }}"
                    method="POST">

                    @csrf

                    <div class="mb-3">
                        <label for="nama_kategori"
                               class="form-label">

                            Nama Kategori
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_kategori"
                            id="nama_kategori"
                            value="{{ old('nama_kategori') }}"
                            class="form-control @error('nama_kategori') is-invalid @enderror"
                            placeholder="Contoh: Programming"
                            required
                            autofocus>

                        @error('nama_kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi"
                               class="form-label">

                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            id="deskripsi"
                            rows="4"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Jelaskan isi kategori ini">{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('kategori.index') }}"
                           class="btn btn-outline-secondary">
                            Batal
                        </a>

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="bi bi-save me-1"></i>
                            Simpan Kategori
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection