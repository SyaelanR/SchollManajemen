<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'siswa';

    /**
     * Atribut yang bisa diisi secara massal (mass-assignable).
     *
     * @var array
     */
    protected $fillable = [
        'nama_siswa',
        'nisn',
        'kelas_id',
        // Tambahkan atribut lain jika ada
    ];

    /**
     * Mendapatkan kelas yang dimiliki siswa ini.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Mendapatkan absensi yang terhubung dengan siswa ini.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
