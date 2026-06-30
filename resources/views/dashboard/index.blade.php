@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container">

    <h1 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Dashboard Perpustakaan
    </h1>

    {{-- Statistik Buku --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h3>{{ $totalBuku }}</h3>
                    <p>Total Buku</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3>{{ $bukuTersedia }}</h3>
                    <p>Buku Tersedia</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <h3>{{ $bukuHabis }}</h3>
                    <p>Buku Habis</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Statistik Anggota --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h3>{{ $totalAnggota }}</h3>
                    <p>Total Anggota</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h3>{{ $anggotaAktif }}</h3>
                    <p>Anggota Aktif</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body text-center">
                    <h3>{{ $anggotaNonaktif }}</h3>
                    <p>Anggota Nonaktif</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Buku Terbaru --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            5 Buku Terbaru
        </div>

        <div class="card-body">
            <ul class="list-group">
                @foreach($bukuTerbaru as $buku)
                    <li class="list-group-item">
                        <strong>{{ $buku->judul }}</strong>
                        <br>
                        <small>{{ $buku->pengarang }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Anggota Terbaru --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            5 Anggota Terbaru
        </div>

        <div class="card-body">
            <ul class="list-group">
                @foreach($anggotaTerbaru as $anggota)
                    <li class="list-group-item">
                        <strong>{{ $anggota->nama }}</strong>
                        <br>
                        <small>{{ $anggota->email }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="card">
        <div class="card-header bg-dark text-white">
            Quick Links
        </div>

        <div class="card-body">

            <a href="{{ route('buku.index') }}"
               class="btn btn-primary me-2">
                <i class="bi bi-book"></i>
                Buku
            </a>

            <a href="{{ route('anggota.index') }}"
               class="btn btn-success me-2">
                <i class="bi bi-people"></i>
                Anggota
            </a>

            <a href="{{ route('kategori.index') }}"
               class="btn btn-info text-white">
                <i class="bi bi-tags"></i>
                Kategori
            </a>

        </div>
    </div>

</div>

@endsection