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
            if (!Schema::hasColumn('users', 'nisn_nip')) {
                $table->string('nisn_nip')->unique()->after('password');
            }
            if (!Schema::hasColumn('users', 'mapel')) {
                $table->string('mapel')->nullable()->after('nisn_nip');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('siswa')->after('mapel'); // Contoh role: siswa, guru, admin
            }
            if (!Schema::hasColumn('users', 'id_kelas')) {
                $table->integer('id_kelas')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'angkatan')) {
                $table->string('angkatan')->nullable()->after('id_kelas');
            }
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('angkatan');
            }
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('jenis_kelamin');
            }


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
            $columnsToDrop = [
                'nisn_nip',
                'mapel',
                'role',
                'id_kelas',
                'angkatan',
                'jenis_kelamin',
                'username'
            ];

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
