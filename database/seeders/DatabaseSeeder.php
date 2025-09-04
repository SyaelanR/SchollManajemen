<?php

namespace Database\Seeders;

use App\Models\User;
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
            'role' => 'admin'
        ]);

        User::create([
            'nisn_nip' => '220103192',
            'name' => 'jarwo',
            'email' => 'jarwo@gmail.com',
            'password' => 'password',
            'username' => 'jarwo',
            'mapel' => 'Matematika',
            'role' => 'guru'
        ]);

        User::create([
            'nisn_nip' => '220103193',
            'name' => 'yono',
            'email' => 'yono@gmail.com',
            'password' => 'password',
            'username' => 'yono',
            'role' => 'siswa'
        ]);
    }
}
