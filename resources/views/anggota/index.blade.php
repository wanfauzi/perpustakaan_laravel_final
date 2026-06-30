@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        Search & Filter Anggota
    </div>

    <div class="card-body">
        <form action="{{ route('search') }}" method="GET">
            <div class="row">

                <div class="col-md-3 mb-2">
                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Cari nama/email/telepon"
                           value="{{ request('keyword') }}">
                </div>

                <div class="col-md-2 mb-2">
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">Semua Jenis Kelamin</option>

                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>

                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <select name="pekerjaan" class="form-select">
                        <option value="">Semua Pekerjaan</option>

                        <option value="Mahasiswa" {{ request('pekerjaan') == 'Mahasiswa' ? 'selected' : '' }}>
                            Mahasiswa
                        </option>

                        <option value="Pegawai" {{ request('pekerjaan') == 'Pegawai' ? 'selected' : '' }}>
                            Pegawai
                        </option>

                        <option value="Wiraswasta" {{ request('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>
                            Wiraswasta
                        </option>
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x"></i> Reset
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-bold mb-1">Data Anggota</h4>
        <p class="text-muted mb-0">Kelola Data Anggota</p>
    </div>

    <div>
        <a href="/anggota/create" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Anggota Baru
        </a>

        <a href="{{ route('anggota.export') }}" class="btn btn-info">
            <i class="bi bi-file-excel"></i> Export Excel
        </a>
    </div>
</div>

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif

@if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        {{ session('error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($anggotas as $anggota)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <span class="fw-semibold">
                                {{ $anggota['kode_anggota'] }}
                            </span>
                        </td>

                        <td>{{ $anggota['nama'] }}</td>

                        <td>{{ $anggota['email'] }}</td>

                        <td>

                            @if($anggota['status'] == 'Aktif')

                                <span class="badge bg-success">
                                    Aktif
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Nonaktif
                                </span>

                            @endif

                        </td>

                        <td>
                            <a href="{{ route('anggota.show', $anggota->id) }}"
                            class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('anggota.edit', $anggota->id) }}"
                            class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('anggota.destroy', $anggota->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus anggota {{ $anggota->nama }}?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            
                        </td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
