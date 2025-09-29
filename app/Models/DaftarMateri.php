<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\table;

class DaftarMateri extends Model
{
    protected $table = 'daftar_materis';

    protected $fillable = [
        'id_daftar_materi',
        'id_mapel',
        'id_kelas',
        'id_sekolah',
        'tingkat',
        'semester',
        'judul_materi',
        'deskripsi_materi',
        'tanggal',
        'nama_file'
    ];

    public function mapel () 
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }

    public function kelas () 
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function sekolah () 
    {
        return $this->belongsTo(Clien::class, 'id_sekolah', 'id_sekolah');
    }

}
