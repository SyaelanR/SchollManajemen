<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class daftar_ruangan extends Model
{
    protected $table = 'daftar_ruangans';

    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'id_ruangan',
        'id_sekolah',
        'nama_ruangan',
        'kapasitas'
    ];
}
