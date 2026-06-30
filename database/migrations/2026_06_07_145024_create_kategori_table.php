<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            // id: bigint, primary key, auto increment
            // nama_kategori: string(50), unique, not null
            // deskripsi: text, nullable
            // icon: string(50), nullable (untuk icon Bootstrap)
            // warna: string(20), nullable (untuk badge color)
            // timestamps: created_at, updated_at
            $table->string('nama_kategori', 50)->unique();
            $table->text('deskripsi')->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('warna', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
