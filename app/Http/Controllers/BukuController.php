<?php
 
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use App\Exports\BukuExport;
use Maatwebsite\Excel\Facades\Excel;

 
class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->search($request);
    }
 
    /**
     * Show the form for creating a new resource.
     */
    // Controller buku baru kategori CRUD
    public function create()
    {
    $kategoris = Kategori::orderBy('nama_kategori')->get();

    return view('buku.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
            $kategori = Kategori::findOrFail($request->kategori_id);

            $data = $request->validated();
            $data['kategori'] = $kategori->nama_kategori;

            Buku::create($data);

            return redirect()
                ->route('buku.index')
                ->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }
        
        /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find buku by ID, throw 404 if not found
        $buku = Buku::findOrFail($id);
        
        // Return view detail buku
        return view('buku.show', compact('buku'));
    }
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil buku yang akan diedit
        $buku = Buku::findOrFail($id);

        // Ambil kategori untuk dropdown
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('buku.edit', compact(
            'buku',
            'kategoris'
        ));
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $kategori = Kategori::findOrFail($request->kategori_id);

            $data = $request->validated();
            $data['kategori'] = $kategori->nama_kategori;

            $buku->update($data);

            return redirect()
                ->route('buku.show', $buku->id)
                ->with('success', 'Data buku berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui buku: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Akan diimplementasi di pertemuan 12
        try {
            $buku = Buku::FindOrFail($id);
            $judulBuku = $buku->judul;

            // Delete Buku
            $buku->delete();

            // Redirect dengan success message
            return redirect()->route('buku.index')
                            ->with('success',"Buku '{$judulBuku}' berhasil dihapus!");
            
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }
    

    /**
     * TUGAS PERTEMUAN 11
     * Search & Filter Buku Advanced
     */
    public function search(Request $request)
    {
        $query = Buku::query();

        // Search keyword (judul, pengarang, penerbit)
        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {

                $q->where('judul', 'like', "%{$keyword}%")
                ->orWhere('pengarang', 'like', "%{$keyword}%")
                ->orWhere('penerbit', 'like', "%{$keyword}%");

            });
        }

        // Filter kategori terbaru
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter tahun terbit
        if ($request->filled('tahun')) {

            $query->where('tahun_terbit', $request->tahun);
        }

        // Filter ketersediaan
        if ($request->filled('status')) {

            if ($request->status == 'tersedia') {

                $query->where('stok', '>', 0);

            } elseif ($request->status == 'habis') {

                $query->where('stok', 0);
            }
        }

        $bukus = $query->latest()->get();

        // Statistik hasil filter
        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('buku.index', compact(
            'bukus',
            'kategoris',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis'
        ));
    }

    // Pertemuan 12
    // Bulk Delete Operations
    
    public function bulkDelete(Request $request)
    {
    $ids = $request->buku_ids;

    if (!$ids) {
        return redirect()
            ->route('buku.index')
            ->with('error', 'Pilih minimal satu buku.');
    }

    Buku::whereIn('id', $ids)->delete();

    return redirect()
        ->route('buku.index')
        ->with('success', count($ids) . ' buku berhasil dihapus!');
    }

    /**
     * Export data buku ke CSV.
     */
    public function export()
    {
        return Excel::download(
            new BukuExport(),
            'data-buku-' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }
}