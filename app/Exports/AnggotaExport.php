<?php

namespace App\Exports;

use App\Models\Anggota;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AnggotaExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithColumnFormatting
{
    public function collection()
    {
        return Anggota::orderBy('nama')->get();
    }

    public function headings(): array
    {
        return [
            'Kode Anggota',
            'Nama',
            'Email',
            'Telepon',
            'Alamat',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Pekerjaan',
            'Status',
            'Tanggal Daftar',
        ];
    }

    public function map($anggota): array
    {
        return [
            $anggota->kode_anggota,
            $anggota->nama,
            $anggota->email,
            $anggota->telepon,
            $anggota->alamat,
            $anggota->tanggal_lahir
                ? Carbon::parse($anggota->tanggal_lahir)->format('d-m-Y')
                : '-',
            $anggota->jenis_kelamin,
            $anggota->pekerjaan ?? '-',
            $anggota->status,
            $anggota->tanggal_daftar
                ? Carbon::parse($anggota->tanggal_daftar)->format('d-m-Y')
                : '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }
}