<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoordenadaMatch extends Model
{
    protected $table = 'coordenadas_match';

    protected $fillable = [
        'user_id',
        'coordenada_bruto_id',
        'latitud',
        'longitud',
        'datetime',
        'datos_bluetooth',
        'recibido_at'
    ];

    protected $casts = [
        'latitud' => 'float',
        'longitud' => 'float',
        'recibido_at' => 'datetime',
        'created_at' => 'datetime'
    ];
}