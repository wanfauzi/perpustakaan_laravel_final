<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
 
class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with(['anggota', 'buku'])
                               ->latest()
                               ->get();
        
        return view('transaksi.index', compact('transaksis'));
    }
 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get only anggota aktif
        $anggotas = Anggota::where('status', 'Aktif')->orderBy('nama')->get();
        
        // Get only buku yang tersedia (stok > 0)
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();
        
        return view('transaksi.create', compact('anggotas', 'bukus'));
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:buku,id',
            'tanggal_pinjam' => 'required|date',
            'keterangan' => 'nullable|string',
        ], [
            'anggota_id.required' => 'Anggota wajib dipilih.',
            'buku_id.required' => 'Buku wajib dipilih.',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
        ]);
        
        try {
            DB::transaction(function () use ($request) {
                // 1. Check stok buku
                $buku = Buku::findOrFail($request->buku_id);
                if ($buku->stok <= 0) {
                    throw new \Exception('Stok buku habis!');
                }
                
                // 2. Generate kode transaksi
                $kodeTransaksi = $this->generateKodeTransaksi();
                
                // 3. Calculate tanggal kembali (7 hari dari tanggal pinjam)
                $tanggalKembali = Carbon::parse($request->tanggal_pinjam)->addDays(7);
                
                // 4. Create transaksi
                Transaksi::create([
                    'kode_transaksi' => $kodeTransaksi,
                    'anggota_id' => $request->anggota_id,
                    'buku_id' => $request->buku_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $tanggalKembali,
                    'status' => 'Dipinjam',
                    'keterangan' => $request->keterangan,
                ]);
                
                // 5. Update stok buku (kurang 1)
                $buku->decrement('stok');
            });
            
            return redirect()->route('transaksi.index')
                             ->with('success', 'Transaksi peminjaman berhasil dibuat!');
                             
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }
 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with(['anggota', 'buku'])->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
 
    /**
     * Kembalikan buku (update status transaksi).
     */
    public function kembalikan(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $transaksi = Transaksi::with('buku')->findOrFail($id);

                // Cek apakah sudah dikembalikan
                if ($transaksi->status === 'Dikembalikan') {
                    throw new \Exception('Buku sudah dikembalikan sebelumnya.');
                }

                $tanggalDikembalikan = now();
                $denda = $this->hitungDenda($transaksi, $tanggalDikembalikan);

                $transaksi->update([
                    'status' => 'Dikembalikan',
                    'tanggal_dikembalikan' => $tanggalDikembalikan,
                    'denda' => $denda,
                ]);

                // Stok buku bertambah 1
                $transaksi->buku->increment('stok');
            });

            return redirect()
                ->route('transaksi.show', $id)
                ->with('success', 'Buku berhasil dikembalikan!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate kode transaksi otomatis.
     */
    private function generateKodeTransaksi()
    {
        $lastTransaksi = Transaksi::latest()->first();
        
        if ($lastTransaksi) {
            $lastNumber = intval(substr($lastTransaksi->kode_transaksi, -3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return 'TRX-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
 
    /**
     * Hitung denda keterlambatan.
     */
    private function hitungDenda($transaksi, $tanggalDikembalikan)
    {
        $tanggalKembali = Carbon::parse($transaksi->tanggal_kembali)->startOfDay();
        $tanggalDikembalikan = Carbon::parse($tanggalDikembalikan)->startOfDay();

        if ($tanggalDikembalikan->greaterThan($tanggalKembali)) {
            $hariTerlambat = (int) $tanggalKembali->diffInDays($tanggalDikembalikan);

            return $hariTerlambat * 5000;
        }

        return 0;
}

    // Export PDF
    public function laporan(Request $request)
    {
        $query = Transaksi::with(['anggota', 'buku']);

        // Filter range tanggal pinjam
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }

        // Filter status
        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // Filter anggota
        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
        }

        $transaksis = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $anggotas = Anggota::orderBy('nama')->get();

        $totalTransaksi = $transaksis->count();
        $totalDenda = $transaksis->sum('denda');

        return view('transaksi.laporan', compact(
            'transaksis',
            'anggotas',
            'totalTransaksi',
            'totalDenda'
        ));
    }

    public function exportPdf(Request $request)
    {
        $query = Transaksi::with(['anggota', 'buku']);

        // Filter range tanggal pinjam
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }

        // Filter status
        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // Filter anggota
        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
        }

        $transaksis = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $totalTransaksi = $transaksis->count();
        $totalDenda = $transaksis->sum('denda');

        $pdf = Pdf::loadView('transaksi.laporan-pdf', compact(
            'transaksis',
            'totalTransaksi',
            'totalDenda'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi.pdf');
    }
}