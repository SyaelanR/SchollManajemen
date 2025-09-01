<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Untuk SQLite kita harus membuat ulang tabel karena CHECK constraint
        // Simpan data lama dulu
        $keuangan = DB::table('keuangan')->get();

        // Hapus tabel lama
        Schema::dropIfExists('keuangan');

        // Buat tabel baru dengan constraint jenis yang diperbarui
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jenis'); // constraint diperbolehkan semua jenis sekarang
            $table->string('deskripsi');
            $table->decimal('jumlah', 15, 2);
            $table->timestamps();
        });

        // Masukkan kembali data lama
        foreach ($keuangan as $item) {
            DB::table('keuangan')->insert([
                'id' => $item->id,
                'tanggal' => $item->tanggal,
                'jenis' => $item->jenis,
                'deskripsi' => $item->deskripsi,
                'jumlah' => $item->jumlah,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
