@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')

{{-- Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-people text-primary me-1"></i>
            Data Anggota
        </h2>

        <p class="text-secondary mb-0">
            Kelola anggota perpustakaan.
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('anggota.export') }}"
           class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel me-1"></i>
            Export Excel
        </a>

        <a href="{{ route('anggota.create') }}"
           class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>
            Tambah Anggota
        </a>

    </div>

</div>

{{-- Alert --}}
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

{{-- Statistik --}}
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card text-bg-primary border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="small opacity-75">
                        Total Anggota
                    </div>

                    <div class="fs-2 fw-bold">
                        {{ $totalAnggota }}
                    </div>
                </div>

                <i class="bi bi-people-fill fs-1 opacity-50"></i>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-success border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="small opacity-75">
                        Anggota Aktif
                    </div>

                    <div class="fs-2 fw-bold">
                        {{ $anggotaAktif }}
                    </div>
                </div>

                <i class="bi bi-person-check-fill fs-1 opacity-50"></i>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-secondary border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <div class="small opacity-75">
                        Anggota Nonaktif
                    </div>

                    <div class="fs-2 fw-bold">
                        {{ $anggotaNonaktif }}
                    </div>
                </div>

                <i class="bi bi-person-x-fill fs-1 opacity-50"></i>

            </div>
        </div>
    </div>

</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-funnel me-1 text-primary"></i>
            Filter Anggota
        </h5>
    </div>

    <div class="card-body">

        <form action="{{ route('anggota.index') }}"
              method="GET">

            <div class="row g-3">

                <div class="col-md-6 col-xl-3">
                    <label for="keyword"
                           class="form-label">
                        Pencarian
                    </label>

                    <input
                        id="keyword"
                        type="search"
                        name="keyword"
                        class="form-control"
                        placeholder="Nama, email, atau telepon"
                        value="{{ request('keyword') }}">
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="jenis_kelamin"
                           class="form-label">
                        Jenis Kelamin
                    </label>

                    <select
                        id="jenis_kelamin"
                        name="jenis_kelamin"
                        class="form-select">

                        <option value="">
                            Semua Jenis Kelamin
                        </option>

                        <option value="Laki-laki"
                            {{ request('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            {{ request('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="status"
                           class="form-label">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="Aktif"
                            {{ request('status') === 'Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="Nonaktif"
                            {{ request('status') === 'Nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>
                </div>

                <div class="col-md-6 col-xl-3">
                    <label for="pekerjaan"
                           class="form-label">
                        Pekerjaan
                    </label>

                    <select
                        id="pekerjaan"
                        name="pekerjaan"
                        class="form-select">

                        <option value="">
                            Semua Pekerjaan
                        </option>

                        <option value="Mahasiswa"
                            {{ request('pekerjaan') === 'Mahasiswa' ? 'selected' : '' }}>
                            Mahasiswa
                        </option>

                        <option value="Pegawai Swasta"
                            {{ request('pekerjaan') === 'Pegawai Swasta' ? 'selected' : '' }}>
                            Pegawai Swasta
                        </option>

                        <option value="Dosen"
                            {{ request('pekerjaan') === 'Dosen' ? 'selected' : '' }}>
                            Dosen
                        </option>

                        <option value="Wiraswasta"
                            {{ request('pekerjaan') === 'Wiraswasta' ? 'selected' : '' }}>
                            Wiraswasta
                        </option>

                    </select>
                </div>

            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">

                <button type="submit"
                        class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>
                    Terapkan Filter
                </button>

                <a href="{{ route('anggota.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Reset
                </a>

            </div>

        </form>

    </div>

</div>

{{-- Tabel --}}
<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">

        <h5 class="fw-bold mb-0">
            Daftar Anggota
        </h5>

        <span class="badge text-bg-primary">
            {{ $anggotas->count() }} data
        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th class="ps-4">Anggota</th>
                    <th>Kode</th>
                    <th>Kontak</th>
                    <th>Jenis Kelamin</th>
                    <th>Pekerjaan</th>
                    <th>Status</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($anggotas as $anggota)

                    <tr>

                        {{-- Nama --}}
                        <td class="ps-4">

                            <div class="d-flex align-items-center gap-3">

                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 42px; height: 42px;">

                                    <span class="fw-bold">
                                        {{ strtoupper(substr($anggota->nama, 0, 1)) }}
                                    </span>

                                </div>

                                <div>
                                    <div class="fw-semibold">
                                        {{ $anggota->nama }}
                                    </div>

                                    <small class="text-secondary">
                                        Terdaftar
                                        {{ $anggota->tanggal_daftar->format('d M Y') }}
                                    </small>
                                </div>

                            </div>

                        </td>

                        {{-- Kode --}}
                        <td>
                            <code>{{ $anggota->kode_anggota }}</code>
                        </td>

                        {{-- Kontak --}}
                        <td>
                            <div>{{ $anggota->email }}</div>

                            <small class="text-secondary">
                                {{ $anggota->telepon }}
                            </small>
                        </td>

                        {{-- Jenis Kelamin --}}
                        <td>
                            {{ $anggota->jenis_kelamin }}
                        </td>

                        {{-- Pekerjaan --}}
                        <td>
                            {{ $anggota->pekerjaan ?: '-' }}
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($anggota->status === 'Aktif')
                                <span class="badge text-bg-success">
                                    Aktif
                                </span>
                            @else
                                <span class="badge text-bg-secondary">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center pe-4">

                            <div class="btn-group btn-group-sm"
                                 role="group">

                                <a href="{{ route('anggota.show', $anggota->id) }}"
                                   class="btn btn-outline-primary"
                                   title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('anggota.edit', $anggota->id) }}"
                                   class="btn btn-outline-warning"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form
                                    action="{{ route('anggota.destroy', $anggota->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus anggota {{ $anggota->nama }}?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger rounded-start-0"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7"
                            class="text-center py-5">

                            <i class="bi bi-people display-5 text-secondary"></i>

                            <p class="text-secondary mt-2 mb-0">
                                Tidak ada data anggota.
                            </p>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection