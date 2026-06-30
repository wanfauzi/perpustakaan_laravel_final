<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\KodeBukuFormat;

class UpdateBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get buku ID from route parameter
        $bukuId = $this->route('buku');

        return [
            'kode_buku' => [
                'required',
                'string',
                'max:20',
                'unique:buku,kode_buku,' . $bukuId,
                new KodeBukuFormat,
            ],
        
            'judul' => 'required|string|max:200',
            'kategori' => 'required|in:Programming,Database,Web Design,Networking,Data Science',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'bahasa' => 'required|string|max:20',
        ];
    }

    // Tugas pertemuan 12 condinional validation
    public function withValidator($validator)
    {
    $validator->after(function ($validator) {

        // Jika kategori Programming maka bahasa harus Inggris
        if (
            $this->kategori === 'Programming' &&
            $this->bahasa !== 'Inggris'
        ) {

            $validator->errors()->add(
                'bahasa',
                'Buku kategori Programming harus menggunakan bahasa Inggris.'
            );

        }

        // Jika tahun terbit kurang dari 2000 maka stok maksimal 5
        if (
            $this->tahun_terbit < 2000 &&
            $this->stok > 5
        ) {

            $validator->errors()->add(
                'stok',
                'Buku yang terbit sebelum tahun 2000 maksimal memiliki stok 5.'
            );
        }
        });
    }
}