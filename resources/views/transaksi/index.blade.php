@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')

{{-- Bootstrap CSS & Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-arrow-left-right"></i>
            Daftar Transaksi Peminjaman
        </h1>

        <div class="d-flex gap-2">
            <a href="{{ route('transaksi.laporan') }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-text"></i> Laporan
            </a>

            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Pinjam Buku
            </a>
        </div>
    </div>

    {{-- Flash Message --}}
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

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Transaksi</h6>
                    <h2 class="mb-0">{{ $transaksis->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Sedang Dipinjam</h6>
                    <h2 class="mb-0">{{ $transaksis->where('status', 'Dipinjam')->count() }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Sudah Dikembalikan</h6>
                    <h2 class="mb-0">{{ $transaksis->where('status', 'Dikembalikan')->count() }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-table"></i>
                Data Transaksi
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Tanggal Dikembalikan</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transaksis as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <code>{{ $transaksi->kode_transaksi }}</code>
                                </td>

                                <td>{{ $transaksi->anggota->nama }}</td>

                                <td>{{ $transaksi->buku->judul }}</td>

                                <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>

                                <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>

                                <td>
                                    @if($transaksi->tanggal_dikembalikan)
                                        {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                                    @else
                                        <span class="text-muted">Belum dikembalikan</span>
                                    @endif
                                </td>

                                <td>
                                    @if($transaksi->status == 'Dipinjam')
                                        <span class="badge bg-warning text-dark">
                                            Dipinjam
                                        </span>

                                        @if($transaksi->terlambat > 0)
                                            <br>
                                            <span class="badge bg-danger mt-1">
                                                Terlambat {{ $transaksi->terlambat }} hari
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-success">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if($transaksi->denda > 0)
                                        <span class="fw-bold text-danger">
                                            Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-success">
                                            Rp 0
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('transaksi.show', $transaksi->id) }}"
                                           class="btn btn-sm btn-info text-white"
                                           title="Detail Transaksi">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Tombol Kembalikan Buku --}}
                                        @if($transaksi->status == 'Dipinjam')
                                            <form action="{{ route('transaksi.kembalikan', $transaksi->id) }}"
                                                method="POST"
                                                class="form-kembalikan">
                                                @csrf
                                                @method('PATCH')

                                                <button type="button"
                                                        class="btn btn-sm btn-success btn-kembalikan"
                                                        title="Kembalikan Buku"
                                                        data-kode="{{ $transaksi->kode_transaksi }}"
                                                        data-buku="{{ $transaksi->buku->judul }}">
                                                    <i class="bi bi-check-circle"></i>
                                                    Kembalikan
                                                </button>
                                            </form>
                                                @else
                                            <button class="btn btn-sm btn-secondary" disabled>
                                                <i class="bi bi-check2-all"></i>
                                                Selesai
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Bootstrap  --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('.btn-kembalikan').forEach(function(button) {
        button.addEventListener('click', function() {
            const form = this.closest('.form-kembalikan');
            const kode = this.getAttribute('data-kode');
            const buku = this.getAttribute('data-buku');

            Swal.fire({
                title: 'Konfirmasi Pengembalian',
                html: `
                    Apakah Anda yakin ingin mengembalikan buku ini?<br>
                    <strong>${buku}</strong><br>
                    <small>Kode Transaksi: ${kode}</small>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kembalikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection