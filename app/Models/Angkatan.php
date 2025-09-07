<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    // protected $table = 'angkatan';
    protected $primaryKey = 'id_angkatan';
    protected $fillable = [
        'id_angkatan',
        'angkatan',
        'id_sekolah'
];
}
