<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clien;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Clien::create([
            'nama_sekolah' => 'SMK Bhakti Mulia Wonogiri',
            'email' => 'bhaktimulia@gmail.com',
            'alamat' => 'Wonogiri',
            'no_telp' => '081234567890',
            'status' => 'Aktif'
        ]);

        User::create([
            'nisn_nip' => '220103190',
            'name' => 'SyaelanR',
            'email' => 'syaelanr@gmail.com',
            'password' => ('password'),
            'username' => 'syaelanr',
            'role' => 'adminDev'
        ]);

        User::create([
            'nisn_nip' => '220103191',
            'name' => 'yanto',
            'email' => 'yanto@gmail.com',
            'password' => 'password',
            'username' => 'yanto',
            'role' => 'admin',
            'id_sekolah' => 1
        ]);

        User::create([
            'nisn_nip' => '220103192',
            'name' => 'jarwo',
            'email' => 'jarwo@gmail.com',
            'password' => 'password',
            'username' => 'jarwo',
            'mapel' => 'Matematika',
            'role' => 'guru',
            'id_sekolah' => 1
        ]);

        User::create([
            'nisn_nip' => '220103193',
            'name' => 'yono',
            'email' => 'yono@gmail.com',
            'password' => 'password',
            'username' => 'yono',
            'role' => 'siswa',
            'id_sekolah' => 1
        ]);
    }
}
