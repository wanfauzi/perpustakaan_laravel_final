<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Perpustakaan</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>
<div class="container-fluid py-3">

    {{-- Judul laporan --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-1">
            Laporan Transaksi Perpustakaan
        </h2>

        <p class="text-muted mb-1">
            Data peminjaman dan pengembalian buku
        </p>

        <small class="text-muted">
            Dicetak pada {{ now()->format('d M Y, H:i') }} WIB
        </small>
    </div>

    {{-- Ringkasan --}}
    <table
        class="table table-bordered mb-4"
        border="1"
        cellspacing="0"
        cellpadding="8"
        width="100%">

        <tr>
            <td width="50%" class="text-center">
                <strong>Total Transaksi</strong>
                <br>
                <span class="fs-4">
                    {{ $totalTransaksi }}
                </span>
            </td>

            <td width="50%" class="text-center">
                <strong>Total Denda</strong>
                <br>
                <span class="fs-4">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </span>
            </td>
        </tr>
    </table>

    {{-- Tabel transaksi --}}
    <table
        class="table table-bordered table-striped table-sm align-middle"
        border="1"
        cellspacing="0"
        cellpadding="6"
        width="100%">

        <thead class="table-light">
            <tr class="text-center">
                <th width="4%">No</th>
                <th width="10%">Kode</th>
                <th width="14%">Anggota</th>
                <th width="18%">Buku</th>
                <th width="10%">Pinjam</th>
                <th width="10%">Batas Kembali</th>
                <th width="10%">Dikembalikan</th>
                <th width="10%">Status</th>
                <th width="14%">Denda</th>
            </tr>
        </thead>

        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $transaksi->kode_transaksi }}
                    </td>

                    <td>
                        {{ $transaksi->anggota?->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $transaksi->buku?->judul ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $transaksi->tanggal_pinjam?->format('d-m-Y') ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $transaksi->tanggal_kembali?->format('d-m-Y') ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $transaksi->tanggal_dikembalikan?->format('d-m-Y') ?? '-' }}
                    </td>

                    <td class="text-center">
                        @if($transaksi->status === 'Dipinjam')
                            <strong>Dipinjam</strong>
                        @else
                            <strong>Dikembalikan</strong>
                        @endif
                    </td>

                    <td class="text-end">
                        @if($transaksi->denda > 0)
                            Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        Tidak ada data transaksi sesuai filter.
                    </td>
                </tr>
            @endforelse
        </tbody>

        @if($transaksis->isNotEmpty())
            <tfoot class="table-light">
                <tr>
                    <th colspan="8" class="text-end">
                        Total Denda
                    </th>

                    <th class="text-end">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </th>
                </tr>
            </tfoot>
        @endif
    </table>

    {{-- Keterangan --}}
    <div class="mt-3">
        <small class="text-muted">
            Laporan ini dibuat otomatis oleh Sistem Informasi Perpustakaan.
        </small>
    </div>

</div>
</body>
</html>