<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapelAjar extends Model
{
    protected $table = 'mapel_ajars';

    protected $primaryKey = 'id_mapel_ajar';

    protected $fillable = [
        'id_mapel_ajar',
        'id_kurikulum',
        'id_mapel',
        'created_at',
        'updated_at'
    ];

    public function mapels()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }
}
