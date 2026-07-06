<?php  
 
namespace App\Http\Controllers;

use App\Http\Requests\StoreAnggotaRequest;
use App\Http\Requests\UpdateAnggotaRequest;
use App\Exports\AnggotaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Anggota;
 
class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      return $this->search($request);
    }
 
    /**
     * Display the specified resource.
     */
    // Show riwayat peminjaman anggota
    public function show(Request $request, string $id)
    {
        $request->validate([
            'status' => 'nullable|in:Dipinjam,Dikembalikan',
        ]);

        $anggota = Anggota::findOrFail($id);

        // Statistik dihitung dari seluruh riwayat
        $totalPinjam = $anggota->transaksis()->count();

        $totalDenda = $anggota->transaksis()
            ->sum('denda');

        $sedangDipinjam = $anggota->transaksis()
            ->where('status', 'Dipinjam')
            ->count();

        // Riwayat dapat difilter berdasarkan status
        $riwayatQuery = $anggota->transaksis()
            ->with('buku')
            ->orderByDesc('tanggal_pinjam');

        if ($request->filled('status')) {
            $riwayatQuery->where('status', $request->status);
        }

        $riwayat = $riwayatQuery->get();

        return view('anggota.show', compact(
            'anggota',
            'riwayat',
            'totalPinjam',
            'totalDenda',
            'sedangDipinjam'
        ));
    }


    private function generateKodeAnggota()
    {
    $tahun = date('Y');
    $lastAnggota = Anggota::whereYear('created_at', $tahun)
                          ->orderBy('kode_anggota', 'desc')
                          ->first();
    
    if ($lastAnggota) {
        $lastNumber = intval(substr($lastAnggota->kode_anggota, -3));
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }
    
    return 'AGT-' . $tahun . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    // Methods lainnya akan diimplementasi di pertemuan 13
    /* Show the form for creating a new resource. */

    public function create() {
        // return view('anggota.create');
        // Ubah create method untuk generate kode
        $kodeAnggota = $this->generateKodeAnggota();

        return view('anggota.create', compact('kodeAnggota'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnggotaRequest $request) 
    { 
        try {
            // Create anggota baru dengan validated data
            Anggota::create($request->validated());
            
            // Redirect dengan success message
            return redirect()->route('anggota.index')
                            ->with('success', 'Anggota berhasil ditambahkan!');
        
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()->with('error', 'Gagal menambahkan anggota: ' . $e->getMessage());
        }
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id) 
    { 
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UpdateAnggotaRequest $request, string $id) 
    { 
        try {
            $anggota = Anggota::findOrFail($id);

            // Update anggota dengan validated data
            $anggota->update($request->validated());

            // Redirect dengan success message
            return redirect()->route('anggota.show', $anggota->id)
                            ->with('success','Data anggota berhasil diupdate!');
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal mengupdate anggota: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $anggota = Anggota::findOrFail($id);
            $namaAnggota = $anggota->nama;
            
            // Delete anggota
            $anggota->delete();
            
            // Redirect dengan success message
            return redirect()->route('anggota.index')
                            ->with('success', "Anggota '{$namaAnggota}' berhasil dihapus!");
                            
        } catch (\Exception $e) {   
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->with('error', 'Gagal menghapus anggota: ' . $e->getMessage());
        }
    }

    // Method search
    public function search(Request $request)
    {
        $query = Anggota::query();

        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('telepon', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->jenis_kelamin) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->pekerjaan) {
            $query->where('pekerjaan', $request->pekerjaan);
        }

        $anggotas = $query->latest()->get();

        // Statistik berdasarkan hasil filter
        $totalAnggota = $anggotas->count();
        $anggotaAktif = $anggotas->where('status', 'Aktif')->count();
        $anggotaNonaktif = $anggotas->where('status', 'Nonaktif')->count();

        return view('anggota.index', compact(
            'anggotas',
            'totalAnggota',
            'anggotaAktif',
            'anggotaNonaktif'
        ));
    }
    
    // Method export excel
    public function export()
    {
        return Excel::download(
            new AnggotaExport(),
            'anggota_' . date('Y-m-d_His') . '.xlsx');
    }
}