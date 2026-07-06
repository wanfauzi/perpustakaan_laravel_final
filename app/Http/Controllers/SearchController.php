<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $keyword = trim($validated['q'] ?? '');
        $results = [
            'buku' => collect(),
            'anggota' => collect(),
            'transaksi' => collect(),
        ];

        if ($keyword !== '') {
            $results['buku'] = Buku::query()
                ->where('judul', 'LIKE', "%{$keyword}%")
                ->orWhere('pengarang', 'LIKE', "%{$keyword}%")
                ->orWhere('isbn', 'LIKE', "%{$keyword}%")
                ->get();

            $results['anggota'] = Anggota::query()
                ->where('nama', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%")
                ->orWhere('kode_anggota', 'LIKE', "%{$keyword}%")
                ->get();

            $results['transaksi'] = Transaksi::with(['anggota', 'buku'])
                ->where('kode_transaksi', 'LIKE', "%{$keyword}%")
                ->orWhereHas('anggota', fn ($query) =>
                    $query->where('nama', 'LIKE', "%{$keyword}%"))
                ->orWhereHas('buku', fn ($query) =>
                    $query->where('judul', 'LIKE', "%{$keyword}%"))
                ->get();
        }

        return view('search.index', compact('keyword', 'results'));
    }
}
