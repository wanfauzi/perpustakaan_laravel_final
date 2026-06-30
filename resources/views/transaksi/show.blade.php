@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

@php
    $tanggalKembali = \Carbon\Carbon::parse($transaksi->tanggal_kembali)->startOfDay();

    $tanggalDikembalikan = null;
    if ($transaksi->tanggal_dikembalikan) {
        $tanggalDikembalikan = \Carbon\Carbon::parse($transaksi->tanggal_dikembalikan)->startOfDay();
    }

    $hariTerlambat = 0;
    $estimasiDenda = 0;

    if ($transaksi->status === 'Dipinjam') {
        $hariIni = today()->startOfDay();

        if ($hariIni->greaterThan($tanggalKembali)) {
            $hariTerlambat = (int) $tanggalKembali->diffInDays($hariIni);
            $estimasiDenda = $hariTerlambat * 5000;
        }
    }

    if ($transaksi->status === 'Dikembalikan' && $tanggalDikembalikan) {
        if ($tanggalDikembalikan->greaterThan($tanggalKembali)) {
            $hariTerlambat = (int) $tanggalKembali->diffInDays($tanggalDikembalikan);
        }
    }
@endphp

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-receipt"></i>
            Detail Transaksi
        </h1>

        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Reminder jika buku masih dipinjam dan sudah melewati tanggal kembali --}}
    @if($transaksi->status === 'Dipinjam' && $hariTerlambat > 0)
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i>
            Buku sudah terlambat dikembalikan selama
            <strong>{{ $hariTerlambat }} hari</strong>.
            Estimasi denda:
            <strong>Rp {{ number_format($estimasiDenda, 0, ',', '.') }}</strong>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-info-circle"></i>
                        Informasi Transaksi
                    </h4>
                </div>

                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <tr>
                            <th width="35%">Kode Transaksi</th>
                            <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                        </tr>

                        <tr>
                            <th>Nama Anggota</th>
                            <td>{{ $transaksi->anggota->nama }}</td>
                        </tr>

                        <tr>
                            <th>Kode Anggota</th>
                            <td>{{ $transaksi->anggota->kode_anggota ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Judul Buku</th>
                            <td>{{ $transaksi->buku->judul }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal Pinjam</th>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal Kembali</th>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal Dikembalikan</th>
                            <td>
                                @if($transaksi->tanggal_dikembalikan)
                                    {{ \Carbon\Carbon::parse($transaksi->tanggal_dikembalikan)->format('d M Y') }}
                                @else
                                    <span class="text-muted">Belum dikembalikan</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if($transaksi->status === 'Dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>

                                    @if($hariTerlambat > 0)
                                        <span class="badge bg-danger">
                                            Terlambat {{ $hariTerlambat }} hari
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>

                                    @if($hariTerlambat > 0)
                                        <span class="badge bg-danger">
                                            Terlambat {{ $hariTerlambat }} hari
                                        </span>
                                    @endif
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Total Denda</th>
                            <td>
                                @if($transaksi->status === 'Dipinjam')
                                    <strong class="{{ $estimasiDenda > 0 ? 'text-danger' : 'text-success' }}">
                                        Rp {{ number_format($estimasiDenda, 0, ',', '.') }}
                                    </strong>
                                    <small class="text-muted d-block">
                                        Estimasi jika dikembalikan hari ini.
                                    </small>
                                @else
                                    <strong class="{{ $transaksi->denda > 0 ? 'text-danger' : 'text-success' }}">
                                        Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                    </strong>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $transaksi->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Aksi Pengembalian --}}
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="bi bi-gear"></i>
                        Aksi Transaksi
                    </h5>
                </div>

                <div class="card-body">
                    @if($transaksi->status === 'Dipinjam')
                        <button type="button" class="btn btn-success w-100" id="btn-kembalikan">
                            <i class="bi bi-arrow-return-left"></i>
                            Kembalikan Buku
                        </button>

                        <form id="form-kembalikan"
                              action="{{ route('transaksi.kembalikan', $transaksi->id) }}"
                              method="POST"
                              class="d-none">
                            @csrf
                            @method('PATCH')
                        </form>
                    @else
                        @if($tanggalDikembalikan && $tanggalDikembalikan->lessThanOrEqualTo($tanggalKembali))
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check-circle"></i>
                                Dikembalikan tepat waktu pada
                                {{ $tanggalDikembalikan->format('d M Y') }}
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-exclamation-triangle"></i>
                                Terlambat dikembalikan!
                                <br>
                                Denda:
                                <strong>
                                    Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                </strong>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="bi bi-cash"></i>
                        Informasi Denda
                    </h5>
                </div>

                <div class="card-body">
                    <p class="mb-1">Denda keterlambatan:</p>
                    <h4 class="text-danger">Rp 5.000 / hari</h4>
                    <small class="text-muted">
                        Denda dihitung otomatis saat tombol Kembalikan Buku ditekan.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('btn-kembalikan')?.addEventListener('click', function() {
    Swal.fire({
        title: 'Konfirmasi Pengembalian',
        text: 'Apakah Anda yakin ingin mengembalikan buku ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Kembalikan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-kembalikan').submit();
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection