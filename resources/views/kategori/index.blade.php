@extends('layouts.app')

@section('content')

<div class="mb-4">

    <div>
        <h2 class="fw-bold mb-1">Kategori Buku</h2>
        <p class="text-muted">
            Daftar kategori yang tersedia di perpustakaan
        </p>
    </div>

</div>

<div class="card shadow-sm">

    <div class="card-body">

        <div class="row mb-3">

            <div class="col-md-4">

                <form action="/kategori/search" method="GET">

                    <div class="input-group">

                        <input type="text"
                               name="keyword"
                               class="form-control"
                               placeholder="Cari kategori">

                        <button class="btn btn-primary">
                            Cari
                        </button>

                    </div>

                </form>

            </div>

        </div>

        <table class="table table-hover">

            <thead class="table-light">

                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Buku</th>
                    <th width="120">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @foreach($kategori_list as $kategori)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <strong>{{ $kategori['nama'] }}</strong>
                    </td>

                    <td>
                        {{ $kategori['deskripsi'] }}
                    </td>

                    <td>

                        <span class="badge bg-primary">
                            {{ $kategori['jumlah_buku'] }}
                        </span>

                    </td>

                    <td>

                        <a href="/kategori/{{ $kategori['id'] }}"
                           class="btn btn-sm btn-outline-primary">

                            Detail

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection