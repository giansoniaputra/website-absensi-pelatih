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
        Schema::create('absensi_pelatihs', function (Blueprint $table) {
            $table->id();
            $table->uuid('unique')->unique();
            $table->string('pelatih_unique');
            $table->string('kode_absensi')->unique();
            $table->date('tanggal_absensi');
            $table->string('kegiatan');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_pelatihs');
    }
};
