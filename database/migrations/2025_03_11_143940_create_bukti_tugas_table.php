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
        Schema::create('bukti_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_pegawai_id')->constrained('tugas_pegawais')->onDelete('cascade');
            $table->string('berkas_path')->nullable();
            $table->string('link_eksternal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_tugas');
    }
};
