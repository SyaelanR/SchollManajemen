<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruEkstra extends Authenticatable
{
    use HasFactory;

    protected $table = 'guru_ekstras';

    protected $fillable = ['nip', 'nama', 'mapel', 'username', 'password'];

    protected $hidden = ['password'];

    public function ekstrakurikulers()
    {
        return $this->hasMany(Ekstrakurikuler::class);
    }
}
