<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jenis'); // ubah dari enum ke string
            $table->string('deskripsi');
            $table->bigInteger('jumlah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
