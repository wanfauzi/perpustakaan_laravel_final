@extends('layouts.app')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/kategori">Kategori</a>
        </li>

        <li class="breadcrumb-item active">
            {{ $kategori['nama'] }}
        </li>
    </ol>
</nav>

<div class="card mb-4">

    <div class="card-header">
        Detail Kategori
    </div>

    <div class="card-body">

        <h3>{{ $kategori['nama'] }}</h3>

        <p>{{ $kategori['deskripsi'] }}</p>

        <span class="badge bg-primary">
            {{ $kategori['jumlah_buku'] }} Buku
        </span>

    </div>

</div>

<div class="card">

    <div class="card-header">
        Daftar Buku
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                </tr>
            </thead>

            <tbody>

                @foreach($buku_list as $buku)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $buku['judul'] }}</td>
                    <td>{{ $buku['penulis'] }}</td>
                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<a href="/kategori" class="btn btn-secondary mt-3">
    Kembali
</a>

@endsection