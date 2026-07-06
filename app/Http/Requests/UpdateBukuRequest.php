<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\KodeBukuFormat;

class UpdateBukuRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge(['harga' => $this->normalizeHarga($this->input('harga'))]);
    }

    private function normalizeHarga(mixed $harga): mixed
    {
        if (! is_string($harga)) {
            return $harga;
        }

        $harga = str_replace(' ', '', trim($harga));

        if (str_contains($harga, ',')) {
            return str_replace(',', '.', str_replace('.', '', $harga));
        }

        return preg_match('/^\d{1,3}(\.\d{3})+$/', $harga)
            ? str_replace('.', '', $harga)
            : $harga;
    }
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
            'kategori_id' => 'required|exists:kategori,id',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20',
            'harga' => 'required|numeric|min:0|decimal:0,2',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'bahasa' => 'required|string|max:20',
        ];
    }
}
