<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tesis extends Model
{
    protected $table = 'tesis';

    protected $primaryKey = 'id_tesis';

    protected $fillable = [
        'titulo',
        'descripcion',
        'url_contenido',
        'fecha_creacion',
        'id_autor',
        'id_area',
        'id_carrera',
    ];

    public function autor()
    {
        return $this->belongsTo(Autor::class, 'id_autor', 'id_autor');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', 'id_carrera');
    }
}

