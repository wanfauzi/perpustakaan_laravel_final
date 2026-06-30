@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Detail Anggota Perpustakaan</h2>

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Kode Anggota</th>
                    <td>{{ $anggota['kode'] }}</td>
                </tr>

                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $anggota['nama'] }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $anggota['email'] }}</td>
                </tr>

                <tr>
                    <th>Telepon</th>
                    <td>{{ $anggota['telepon'] }}</td>
                </tr>

                <tr>
                    <th>Alamat</th>
                    <td>{{ $anggota['alamat'] }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($anggota['status'] == 'Aktif')
                            <span class="badge bg-success">
                                {{ $anggota['status'] }}
                            </span>
                        @else
                            <span class="badge bg-danger">
                                {{ $anggota['status'] }}
                            </span>
                        @endif
                    </td>
                </tr>
            </table>

            <a href="/anggota" class="btn btn-secondary">
                ← Kembali ke Daftar
            </a>

        </div>
    </div>

</div>
@endsection