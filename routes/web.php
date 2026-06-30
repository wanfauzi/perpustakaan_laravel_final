<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
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
 
    // Buku - CRUD
    Route::resource('buku', BukuController::class);
 
    // Anggota - CRUD
    // Export Anggota
    Route::get('/anggota/export', [AnggotaController::class, 'export'])
    ->name('anggota.export');
    
    Route::resource('anggota', AnggotaController::class);
    
    // Export PDF
    Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])
    ->name('transaksi.laporan');

    Route::get('/transaksi/laporan/export-pdf', [TransaksiController::class, 'exportPdf'])
    ->name('transaksi.laporan.pdf');
    
    // Transaksi - CRUD + Custom routes
    // Menggunakan Method PATCH
    Route::patch('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])
    ->name('transaksi.kembalikan');

    Route::resource('transaksi', TransaksiController::class);

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');
});
 
require __DIR__.'/auth.php';