<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_category_can_be_updated_to_a_dynamic_category(): void
    {
        $user = User::factory()->create();
        $database = Kategori::create(['nama_kategori' => 'Database']);
        $pengembanganDiri = Kategori::create(['nama_kategori' => 'Pengembangan Diri']);

        $buku = Buku::create([
            'kode_buku' => 'BK-DBS-001',
            'judul' => 'Dasar Database',
            'kategori' => $database->nama_kategori,
            'kategori_id' => $database->id,
            'pengarang' => 'Penulis Uji',
            'penerbit' => 'Penerbit Uji',
            'tahun_terbit' => 2024,
            'harga' => 99900,
            'stok' => 5,
            'bahasa' => 'Indonesia',
        ]);

        $response = $this->actingAs($user)->put(route('buku.update', $buku), [
            'kode_buku' => $buku->kode_buku,
            'judul' => $buku->judul,
            'kategori_id' => $pengembanganDiri->id,
            'pengarang' => $buku->pengarang,
            'penerbit' => $buku->penerbit,
            'tahun_terbit' => $buku->tahun_terbit,
            'isbn' => null,
            'harga' => '99.900,00',
            'stok' => $buku->stok,
            'deskripsi' => null,
            'bahasa' => 'Indonesia',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('buku.show', $buku));

        $this->assertDatabaseHas('buku', [
            'id' => $buku->id,
            'kategori_id' => $pengembanganDiri->id,
            'kategori' => 'Pengembangan Diri',
            'bahasa' => 'Indonesia',
            'harga' => 99900,
        ]);
    }
}