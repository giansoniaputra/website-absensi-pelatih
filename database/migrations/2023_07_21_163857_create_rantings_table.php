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
        Schema::create('rantings', function (Blueprint $table) {
            $table->id();
            $table->uuid('unique')->unique();
            $table->string('kode_ranting');
            $table->string('nama_ranting');
            $table->string('jenjang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rantings');
    }
};
