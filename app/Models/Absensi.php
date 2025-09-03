<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'absensi';

    /**
     * Atribut yang bisa diisi secara massal (mass-assignable).
     *
     * @var array
     */
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'status',
        'tanggal',
        // Tambahkan atribut lain jika ada
    ];

    /**
     * Mendapatkan siswa yang terhubung dengan absensi ini.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Mendapatkan guru yang terhubung dengan absensi ini.
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
