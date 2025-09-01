<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->string('nama_siswa')->nullable()->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropColumn('nama_siswa');
        });
    }
};
