@extends('layouts.app')
@section('title', 'Pencarian')

@section('content')
@php
    $highlight = static function (?string $text, string $keyword): string {
        $escapedText = e($text ?? '');

        if ($keyword === '') {
            return $escapedText;
        }

        return preg_replace(
            '/(' . preg_quote(e($keyword), '/') . ')/iu',
            '<mark>$1</mark>',
            $escapedText
        ) ?? $escapedText;
    };
@endphp

<div class="container py-4">
    <h2>Hasil Pencarian: "{{ $keyword }}"</h2>

    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab-buku">
                Buku ({{ $results['buku']->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-anggota">
                Anggota ({{ $results['anggota']->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-transaksi">
                Transaksi ({{ $results['transaksi']->count() }})
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab-buku">
            @forelse($results['buku'] as $buku)
                <div class="card mb-2">
                    <div class="card-body">
                        <h6>{!! $highlight($buku->judul, $keyword) !!}</h6>
                        <small class="text-muted">
                            {!! $highlight($buku->pengarang, $keyword) !!}
                            @if($buku->isbn)
                                — ISBN: {!! $highlight($buku->isbn, $keyword) !!}
                            @endif
                            — Stok: {{ $buku->stok }}
                        </small>
                    </div>
                </div>
            @empty
                <p class="text-muted">Tidak ada buku yang cocok.</p>
            @endforelse
        </div>

        <div class="tab-pane fade" id="tab-anggota">
            @forelse($results['anggota'] as $anggota)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">
                            {!! $highlight($anggota->nama, $keyword) !!}
                        </h6>
                        <small class="text-secondary">
                            {!! $highlight($anggota->kode_anggota, $keyword) !!}
                            &mdash;
                            {!! $highlight($anggota->email, $keyword) !!}
                        </small>
                    </div>
                </div>
            @empty
                <div class="text-center text-secondary py-4">
                    Tidak ada anggota yang cocok.
                </div>
            @endforelse
        </div>

        <div class="tab-pane fade" id="tab-transaksi">
            @forelse($results['transaksi'] as $trx)
                <div class="card mb-2">
                    <div class="card-body">
                        <h6>{!! $highlight($trx->kode_transaksi, $keyword) !!}</h6>
                        <small>
                            {!! $highlight($trx->anggota->nama, $keyword) !!}
                            — {!! $highlight($trx->buku->judul, $keyword) !!}
                        </small>
                    </div>
                </div>
            @empty
                <p class="text-muted">Tidak ada transaksi yang cocok.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection