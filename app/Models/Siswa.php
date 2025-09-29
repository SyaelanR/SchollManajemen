<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Ekskul\Ekskul;
use App\Models\Ekskul\EkskulAbsensi;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas'; // pastikan migration siswa pakai nama ini
    protected $fillable = ['nama', 'kelas', 'alamat'];

    /**
     * Relasi: Siswa ikut banyak ekskul (pivot ekskul_siswa)
     */
    public function ekskuls()
    {
        return $this->belongsToMany(Ekskul::class, 'ekskul_siswa', 'siswa_id', 'ekskul_id');
    }

    /**
     * Relasi: Siswa punya banyak absensi
     */
    public function absensiEkskul()
    {
        return $this->hasMany(EkskulAbsensi::class, 'siswa_id');
    }
}
