<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapels';
    protected $primaryKey = 'id_mapel';
    protected $fillable = [
        'nama_mapel',
        'id_guru',
        'id_sekolah',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'id_guru', 'id');
    }
}
