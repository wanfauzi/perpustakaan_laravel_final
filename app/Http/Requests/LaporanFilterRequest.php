<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date', 'after_or_equal:dari'],
            'status' => ['nullable', 'in:Dipinjam,Dikembalikan'],
            'anggota_id' => ['nullable', 'integer', 'exists:anggota,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'dari.date' => 'Tanggal awal tidak valid.',
            'sampai.date' => 'Tanggal akhir tidak valid.',
            'sampai.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal awal.',
            'status.in' => 'Status transaksi tidak valid.',
            'anggota_id.integer' => 'Anggota yang dipilih tidak valid.',
            'anggota_id.exists' => 'Anggota yang dipilih tidak ditemukan.',
        ];
    }
}