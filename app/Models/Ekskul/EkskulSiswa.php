<?php

namespace App\Models\Ekskul;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EkskulSiswa extends Model
{
    use HasFactory;

    protected $table = 'ekskul_siswa';
    protected $fillable = ['siswa_id', 'ekskul_id'];

    /**
     * Relasi: EkskulSiswa → Ekskul
     */
    public function ekskul()
    {
        return $this->belongsTo(Ekskul::class, 'ekskul_id');
    }

    /**
     * Relasi: EkskulSiswa → Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class, 'siswa_id');
    }
}
