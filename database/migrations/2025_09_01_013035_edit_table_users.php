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
        Schema::table('users', function (Blueprint $table) {
            $table->text('password')->change();
            $table->text('nisn_nip')->unique()->after('password');
            $table->string('mapel')->nullable()->after('nisn_nip');
            $table->string('role')->default('siswa')->after('mapel'); // Contoh role: siswa, guru, admin
            $table->integer('id_kelas')->nullable()->after('role');
            $table->string('angkatan')->nullable()->after('id_kelas');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('angkatan');
            $table->string('username')->unique()->after('jenis_kelamin');


            // Tips: Jika Anda sudah memiliki tabel 'kelas', Anda bisa menambahkan foreign key constraint.
            // Cukup hapus komentar pada baris di bawah ini.
            // $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nisn_nip',
                'mapel',
                'role',
                'id_kelas',
                'angkatan',
                'jenis_kelamin'
            ]);
        });
    }
};
