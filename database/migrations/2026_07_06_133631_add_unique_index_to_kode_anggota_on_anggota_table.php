<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateKode = DB::table('anggota')
            ->select('kode_anggota')
            ->groupBy('kode_anggota')
            ->havingRaw('COUNT(*) > 1')
            ->value('kode_anggota');

        if ($duplicateKode !== null) {
            throw new RuntimeException(
                "Unique index kode_anggota tidak dapat dibuat karena kode {$duplicateKode} duplikat."
            );
        }

        Schema::table('anggota', function (Blueprint $table) {
            $table->unique('kode_anggota');
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropUnique(['kode_anggota']);
        });
    }
};