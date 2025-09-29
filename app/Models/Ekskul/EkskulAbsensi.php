<?php

namespace App\Models\Ekskul;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EkskulAbsensi extends Model
{
    use HasFactory;

    protected $table = 'ekskul_absensi';
    protected $fillable = ['siswa_id', 'ekskul_id', 'tanggal', 'keterangan'];

    /**
     * Relasi: Absensi → Ekskul
     */
    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'ekskul_id');
    }

    /**
     * Relasi: Absensi → Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class, 'siswa_id');
    }
}
