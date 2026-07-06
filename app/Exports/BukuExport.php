<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BukuExport implements 
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         return Buku::with('kategoriData')
            ->orderBy('judul')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Buku',
            'Judul',
            'Kategori',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'ISBN',
            'Bahasa',
            'Harga',
            'Stok',
        ];
    }

    public function map($buku): array
    {
        return [
            $buku->kode_buku,
            $buku->judul,
            $buku->kategoriData?->nama_kategori ?? $buku->kategori ?? '-',
            $buku->pengarang,
            $buku->penerbit,
            $buku->tahun_terbit,
            $buku->isbn ?? '-',
            $buku->bahasa,
            $buku->harga,
            $buku->stok,
        ];
    }
}

