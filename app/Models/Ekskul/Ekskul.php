<?php

namespace App\Models\Ekskul;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekskul extends Model
{
    use HasFactory;

    protected $table = 'ekskuls';
    protected $fillable = ['nama_ekskul', 'jadwal', 'keterangan', 'pembina_id'];

    /**
     * Relasi: Ekskul → Pembina
     */
    public function pembina()
    {
        return $this->belongsTo(Pembina::class, 'pembina_id');
    }

    /**
     * Relasi: Ekskul → banyak siswa (pivot ekskul_siswa)
     */
    public function siswa()
    {
        return $this->belongsToMany(\App\Models\Siswa::class, 'ekskul_siswa', 'ekskul_id', 'siswa_id');
    }

    /**
     * Relasi: Ekskul → banyak absensi
     */
    public function absensi()
    {
        return $this->hasMany(EkskulAbsensi::class, 'ekskul_id');
    }
}
