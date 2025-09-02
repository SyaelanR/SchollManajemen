<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikuler'; // pastikan ini sesuai nama tabel di database

    protected $fillable = ['name', 'category', 'description', 'instructor', 'schedule'];
}
