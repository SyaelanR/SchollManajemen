<?php

namespace App\Models\ekskul1\guru;

use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    protected $table = 'ekskuls'; // Nama tabel di SQLite
    protected $fillable = [
        'nama', 'kategori', 'deskripsi', 'pembimbing', 'jadwal', 'pembina_id'
    ];
}
