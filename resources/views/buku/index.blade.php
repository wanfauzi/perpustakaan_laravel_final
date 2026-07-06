@extends('layouts.app')
 
@section('title', 'Daftar Buku')
 
@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-book text-primary me-1"></i>
            Data Buku
        </h2>

        <p class="text-secondary mb-0">
            Kelola koleksi buku perpustakaan
        </p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('buku.export') }}"
           class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel me-1"></i>
                Export Excel
        </a>

        <a href="{{ route('buku.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Buku
        </a>
    </div>
</div>
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card text-bg-primary border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Buku</div>
                    <div class="fs-2 fw-bold">{{ $totalBuku }}</div>
                </div>

                <i class="bi bi-book-fill fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-success border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Buku Tersedia</div>
                    <div class="fs-2 fw-bold">{{ $bukuTersedia }}</div>
                </div>

                <i class="bi bi-check-circle-fill fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-danger border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Buku Habis</div>
                    <div class="fs-2 fw-bold">{{ $bukuHabis }}</div>
                </div>

                <i class="bi bi-x-circle-fill fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        Search & Filter Buku
    </div>

    <div class="card-body">

        <form action="{{ route('buku.index') }}" method="GET">

            <div class="row">

                <div class="col-md-3 mb-2">
                    <input
                        type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Judul, Pengarang, Penerbit"
                        value="{{ request('keyword') }}">
                </div>

                <div class="col-md-2 mb-2">

                    <select name="kategori_id" class="form-select">
                        <option value="">Semua Kategori</option>

                        @foreach($kategoris as $kategori)
                            <option
                                value="{{ $kategori->id }}"
                                {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>

                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-2 mb-2">

                    <select name="tahun" class="form-select">

                        <option value="">
                            Semua Tahun
                        </option>

                        @for($tahun = date('Y'); $tahun >= 2020; $tahun--)

                            <option value="{{ $tahun }}">
                                {{ $tahun }}
                            </option>

                        @endfor

                    </select>

                </div>

                <div class="col-md-2 mb-2">

                    <select name="status" class="form-select">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="tersedia">
                            Tersedia
                        </option>

                        <option value="habis">
                            Habis
                        </option>

                    </select>

                </div>

                <div class="col-md-3 mb-2">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="bi bi-search"></i>
                        Cari

                    </button>

                    <a
                        href="{{ route('buku.index') }}"
                        class="btn btn-secondary">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>
</div>


 
{{-- Filter Kategori --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <h6 class="fw-bold mb-3">
            <i class="bi bi-funnel me-1"></i>
            Filter Kategori
        </h6>

        <div class="d-flex flex-wrap gap-2">

            <a
                href="{{ route(
                    'buku.index',
                    request()->except('kategori_id', 'page')
                ) }}"
                class="btn btn-sm {{ !request('kategori_id')
                    ? 'btn-primary'
                    : 'btn-outline-primary' }}">

                Semua
            </a>

            @foreach($kategoris as $kategori)
                <a
                    href="{{ route(
                        'buku.index',
                        array_merge(
                            request()->except('page'),
                            ['kategori_id' => $kategori->id]
                        )
                    ) }}"
                    class="btn btn-sm {{ request('kategori_id') == $kategori->id
                        ? 'btn-primary'
                        : 'btn-outline-primary' }}">

                    {{ $kategori->nama_kategori }}
                </a>
            @endforeach

        </div>
    </div>
</div>
 
{{-- Daftar Buku --}}

<form action="{{ route('buku.bulk-delete') }}" method="POST">
    @csrf
    @method('DELETE')
    
    <div class="d-flex align-items-center gap-3 mb-4">

        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="select-all">

            <label
                class="form-check-label"
                for="select-all">

                Pilih Semua

            </label>
        </div>

        <button
            type="submit"
            class="btn btn-danger btn-sm">

            <i class="bi bi-trash"></i>
            Hapus Terpilih

        </button>

    </div>

    <div class="row">

        @forelse($bukus as $buku)

            <div class="col-md-6 col-xl-4 mb-4">

                <x-buku-card
                    :buku="$buku"
                    :selectable="true"
                />

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info">
                    Tidak ada data buku
                </div>
            </div>

        @endforelse

    </div>

</form>

@if ($bukus->count() > 0)
    <div class="text-center mt-4">
        <p class="text-muted">
            Menampilkan {{ $bukus->count() }} buku

            @if(request('kategori_id'))
                @php
                    $kategoriDipilih = $kategoris->firstWhere(
                        'id',
                        (int) request('kategori_id')
                    );
                @endphp

                @if($kategoriDipilih)
                    dari kategori
                    <strong>
                        {{ $kategoriDipilih->nama_kategori }}
                    </strong>
                @endif
            @endif

        </p>
    </div>
@endif


@push('scripts')
<script>
    
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('select-all');

    selectAll?.addEventListener('change', function () {
        document
            .querySelectorAll('input[name="buku_ids[]"]')
            .forEach(function (checkbox) {
                checkbox.checked = selectAll.checked;
            });
    });
});
</script>
@endpush


@endsection