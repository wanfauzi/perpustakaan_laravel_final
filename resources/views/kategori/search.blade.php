@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            Hasil Pencarian Kategori
        </h2>

        <p class="text-muted mb-0">
            Keyword:
            <mark>{{ $keyword }}</mark>
        </p>
    </div>

    <a href="/kategori"
       class="btn btn-secondary">
        ← Kembali
    </a>

</div>

@if(count($kategori_list) > 0)

<div class="alert alert-success">

    Ditemukan
    <strong>{{ count($kategori_list) }}</strong>
    kategori.

</div>

<div class="row">

    @foreach($kategori_list as $kategori)

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h5 class="card-title">
                    {{ $kategori['nama'] }}
                </h5>

                <p class="text-muted">
                    {{ $kategori['deskripsi'] }}
                </p>

                <span class="badge bg-primary">
                    {{ $kategori['jumlah_buku'] }} Buku
                </span>

            </div>

            <div class="card-footer bg-white">

                <a href="/kategori/{{ $kategori['id'] }}"
                   class="btn btn-primary btn-sm">

                    Lihat Detail

                </a>

            </div>

        </div>

    </div>

    @endforeach

</div>

@else

<div class="alert alert-warning">

    <h5>Tidak Ada Hasil</h5>

    <p class="mb-0">

        Tidak ditemukan kategori dengan keyword:

        <strong>{{ $keyword }}</strong>

    </p>

</div>

@endif

@endsection