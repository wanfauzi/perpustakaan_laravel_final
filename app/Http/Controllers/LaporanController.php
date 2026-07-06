<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanFilterRequest;
use App\Models\Anggota;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;

class LaporanController extends Controller
{
    public function index(LaporanFilterRequest $request)
    {
        $filters = $request->validated();
        $transaksis = $this->filteredQuery($filters)
            ->latest()
            ->get();

        $summary = [
            'total' => $transaksis->count(),
            'dipinjam' => $transaksis->where('status', 'Dipinjam')->count(),
            'dikembalikan' => $transaksis->where('status', 'Dikembalikan')->count(),
            'total_denda' => $transaksis->sum('denda'),
        ];

        $anggotas = Anggota::orderBy('nama')->get();

        return view('laporan.index', compact('transaksis', 'summary', 'anggotas'));
    }

    public function exportPdf(LaporanFilterRequest $request)
    {
        $filters = $request->validated();
        $transaksis = $this->filteredQuery($filters)
            ->orderByDesc('tanggal_pinjam')
            ->get();

        $totalTransaksi = $transaksis->count();
        $totalDenda = $transaksis->sum('denda');

        $pdf = Pdf::loadView(
            'transaksi.laporan-pdf',
            compact('transaksis', 'totalTransaksi', 'totalDenda')
        )->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi-' . date('Y-m-d') . '.pdf');
    }

    private function filteredQuery(array $filters): Builder
    {
        return Transaksi::with(['anggota', 'buku'])
            ->when(
                $filters['dari'] ?? null,
                fn (Builder $query, string $date) =>
                    $query->whereDate('tanggal_pinjam', '>=', $date)
            )
            ->when(
                $filters['sampai'] ?? null,
                fn (Builder $query, string $date) =>
                    $query->whereDate('tanggal_pinjam', '<=', $date)
            )
            ->when(
                $filters['status'] ?? null,
                fn (Builder $query, string $status) =>
                    $query->where('status', $status)
            )
            ->when(
                $filters['anggota_id'] ?? null,
                fn (Builder $query, int|string $anggotaId) =>
                    $query->where('anggota_id', $anggotaId)
            );
    }
}