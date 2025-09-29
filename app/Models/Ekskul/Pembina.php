<?php

namespace App\Models\Ekskul;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembina extends Model
{
    use HasFactory;

    protected $table = 'pembinas';
    protected $fillable = ['nama', 'jabatan'];

    /**
     * Relasi: 1 pembina → banyak ekskul
     */
    public function ekskuls()
    {
        return $this->hasMany(Ekskul::class, 'pembina_id');
    }
}
