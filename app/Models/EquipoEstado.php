<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoEstado extends Model
{
    use HasFactory;

    protected $table = 'equipo_estados';

    protected $fillable = [
        'mac',
        'cerrado',
        'latitud',
        'longitud',
        'datetime',
    ];
}
