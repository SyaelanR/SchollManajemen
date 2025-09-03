<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'kelas';

    /**
     * Atribut yang bisa diisi secara massal (mass-assignable).
     *
     * @var array
     */
    protected $fillable = [
        'nama_kelas',
        // Tambahkan atribut lain jika ada
    ];

    /**
     * Mendapatkan siswa yang terhubung dengan kelas ini.
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
