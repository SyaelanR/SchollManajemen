<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarNilai extends Model
{
    protected $table = 'daftar_nilais';
    protected $primaryKey = 'id_daftar_nilai';
    protected $fillable = [
        'id_mapel',
        'tipe_nilai',
        'keterangan',
        'tanggal',
        'id_sekolah',
        'tingkat',
        'semester',
        'id_kelas',
    ];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}
