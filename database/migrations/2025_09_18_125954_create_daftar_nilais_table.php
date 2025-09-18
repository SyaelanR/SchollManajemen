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
        Schema::create('daftar_nilais', function (Blueprint $table) {
            $table->id('id_daftar_nilai');
            $table->unsignedBigInteger('id_mapel')->nullable();
            $table->string('tipe_nilai')->nullable();
            $table->string('keterangan')->nullable();
            $table->date('tanggal')->nullable();
            $table->unsignedBigInteger('id_sekolah')->nullable();
            $table->unsignedBigInteger('id_kelas')->nullable();
            $table->integer('tingkat')->nullable();
            $table->enum('semester', ['Ganjil', 'Genap'])->nullable();
            $table->timestamps();

            $table->foreign('id_mapel')->references('id_mapel')->on('mapels')->onDelete('set null');
            $table->foreign('id_sekolah')->references('id_sekolah')->on('cliens')->onDelete('set null');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_nilais');
    }
};
