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
        Schema::create('angkatans', function (Blueprint $table) {
            $table->id('id_angkatan'); // ->primary() sudah implisit
            $table->string('angkatan');
            $table->unsignedBigInteger('id_sekolah')->nullable();
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();

            $table->foreign('id_sekolah')->references('id_sekolah')->on('cliens')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angkatans');
    }
};
