<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ekstras', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori', 50);
            $table->text('deskripsi')->nullable();
            $table->string('pembimbing');
            $table->string('jadwal', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekstras');
    }
};
