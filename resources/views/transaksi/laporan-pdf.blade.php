<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">

    <div class="text-center mb-4">
        <h3 class="fw-bold mb-1">Laporan Transaksi Perpustakaan</h3>
        <p class="mb-0">Sistem Informasi Perpustakaan</p>
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <div class="border rounded p-3">
                <p class="mb-1 text-muted">Total Transaksi</p>
                <h4 class="fw-bold mb-0">{{ $totalTransaksi }}</h4>
            </div>
        </div>

        <div class="col-6">
            <div class="border rounded p-3">
                <p class="mb-1 text-muted">Total Denda</p>
                <h4 class="fw-bold mb-0">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </h4>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped table-sm">
        <thead class="table-light">
            <tr class="text-center">
                <th>No</th>
                <th>Kode</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Tgl Dikembalikan</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>

        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                    <td>{{ $transaksi->anggota->nama }}</td>
                    <td>{{ $transaksi->buku->judul }}</td>
                    <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                    <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                    <td>
                        @if($transaksi->tanggal_dikembalikan)
                            {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($transaksi->status == 'Dipinjam')
                            <span class="badge bg-warning text-dark">Dipinjam</span>
                        @else
                            <span class="badge bg-success">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="text-end">
                        Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">
                        Tidak ada data transaksi
                    </td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th colspan="8" class="text-end">Total Denda</th>
                <th class="text-end">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>

    <div class="mt-4">
        <p class="text-muted mb-0">
            Dicetak pada: {{ now()->format('d M Y H:i') }}
        </p>
    </div>

</div>

</body>
</html>