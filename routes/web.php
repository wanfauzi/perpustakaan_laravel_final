<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
 
// Public routes (tanpa auth)
Route::get('/', function () {
    return redirect()->route('login');
});
 
// Protected routes (dengan auth middleware)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
 
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/buku/export', [BukuController::class, 'export'])
    ->name('buku.export');

    Route::delete('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])
    ->name('buku.bulk-delete'); 
    
    // Buku - CRUD
    Route::resource('buku', BukuController::class);
 
    // Anggota - CRUD
    // Export Anggota
    Route::get('/anggota/export', [AnggotaController::class, 'export'])
    ->name('anggota.export');
    
    Route::resource('anggota', AnggotaController::class);
    
    // Export PDF
    Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');

    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])
    ->name('laporan.pdf');
    
    // Transaksi - CRUD + Custom routes
    // Menggunakan Method PATCH
    Route::patch('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])
    ->name('transaksi.kembalikan');

    Route::resource('transaksi', TransaksiController::class)
        ->only(['index', 'create', 'store', 'show']);

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Kategori
    Route::resource('kategori', KategoriController::class);
    });
 
require __DIR__.'/auth.php';