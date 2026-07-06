<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Buku extends Model
{
    use HasFactory;
 
    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'buku';
 
    /**
     * Kolom yang dapat diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_buku',
        'judul',
        'kategori',
        'kategori_id',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'harga',
        'stok',
        'deskripsi',
        'bahasa'
    ];
 
    /**
     * Tipe casting untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tahun_terbit' => 'integer',
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];
 
    /**
     * Accessor untuk format harga.
     */
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
 
    /**
     * Accessor untuk status ketersediaan.
     */
    public function getTersediaAttribute(): bool
    {
        return $this->stok > 0;
    }
 
    /**
     * Scope untuk filter buku tersedia.
     */
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }
 
    /**
     * Scope untuk filter berdasarkan kategori.
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // PERTEMUAN 10
    // ACCESSOR DAB LOCAL SCOPE DI ELOQUENT MODEL

    // Accessor Status Stok Badge 
    public function getStatusStokBadgeAttribute():string
    {
         if ($this->stok == 0) {
            return '<span class="badge bg-danger">Habis</span>';
        } elseif ($this->stok <= 5) {
            return '<span class="badge bg-warning">Menipis</span>';
        } elseif ($this->stok <= 15) {
            return '<span class="badge bg-info">Sedang</span>';
        }

        return '<span class="badge bg-success">Aman</span>';
    }

    // Accessor Tahun Label
    public function getTahunLabelAttribute():string 
    {
        if ($this->tahun_terbit >= 2024) {
            return 'Buku Baru';
        }

        return 'Buku Lama';
    }

    // Scope Stok Menipis
    public function scopeStokMenipis($query)
    {
        return $query->where('stok', '<', 5);
    }

    // Scope Harga Range
    public function scopeHargaRange($query, $min, $max) 
    {
        return $query->whereBetween('harga', [$min, $max]);
    }

    // Scope Buku Terbaru   
    public function scopeTerbaru($query)
    {
        return $query->where('tahun_terbit', '>=', 2024);
    }

    // Update model buku - tambah relasi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Relasi pada model buku kategori
    public function kategoriData()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}