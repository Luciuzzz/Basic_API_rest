<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autores';

    protected $primaryKey = 'id_autor';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
    ];
}
