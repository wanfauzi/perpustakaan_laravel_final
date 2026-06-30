<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriList = [
            [
                'nama_kategori' => 'Programming',
                'deskripsi' => 'Kategori buku pemrograman dan coding',
                'icon' => 'code-slash',
                'warna' => 'primary',
            ],
            [
                'nama_kategori' => 'Database',
                'deskripsi' => 'Kategori buku database dan SQL',
                'icon' => 'database',
                'warna' => 'success',
            ],
            [
                'nama_kategori' => 'Web Design',
                'deskripsi' => 'Kategori buku desain web dan UI/UX',
                'icon' => 'palette',
                'warna' => 'info',
            ],
            [
                'nama_kategori' => 'Networking',
                'deskripsi' => 'Kategori buku jaringan komputer',
                'icon' => 'wifi',
                'warna' => 'warning',
            ],
            [
                'nama_kategori' => 'Data Science',
                'deskripsi' => 'Kategori buku data science dan AI',
                'icon' => 'graph-up',
                'warna' => 'danger',
            ],
        ];

        foreach ($kategoriList as $kategori) {
            Kategori::create($kategori);
        }
    }
}