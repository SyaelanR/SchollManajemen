<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clien extends Model
{
    // protected $table = 'cliens'; gunakan jika nama tabel tidak sesuai dengan nama model (jamak)
    protected $primaryKey = 'id_sekolah';
    protected $fillable = ['
        id_sekolah',
        'nama_sekolah',
        'email',
        'alamat',
        'no_telp',
        'status'
];
    
}
