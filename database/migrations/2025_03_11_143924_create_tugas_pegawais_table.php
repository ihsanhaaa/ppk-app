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
        Schema::create('tugas_pegawais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id');
            $table->foreignId('user_id');
            // $table->foreignId('tugas_id')->nullable();
            $table->foreignId('semester_id');
            $table->integer('points')->default(0);
            $table->text('nama_tugas');
            $table->text('keterangan')->nullable();
            $table->enum('progres', ['todo', 'in-progress', 'done'])->default('todo');
            $table->enum('jenis_pekerjaan', ['Bulanan', 'Semesteran', 'Tahunan']);
            $table->string('prioritas')->default('normal');
            $table->string('reviewer')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_pegawais');
    }
};
