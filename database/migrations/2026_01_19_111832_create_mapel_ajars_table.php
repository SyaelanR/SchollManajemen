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
        Schema::create('mapel_ajars', function (Blueprint $table) {
            $table->id('id_mapel_ajar');
            $table->unsignedBigInteger('id_kurikulum')->nullable();
            $table->unsignedBigInteger('id_mapel')->nullable();
            $table->timestamps();

            $table->foreign('id_kurikulum')->references('id_kurikulum')->on('daftar_kurikulums')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel_ajars');
    }
};
