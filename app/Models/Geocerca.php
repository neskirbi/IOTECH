<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Geocerca extends Model
{
    use HasFactory;

    protected $table = 'geocercas';
    
    protected $primaryKey = 'id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'id',
        'id_administrador',
        'nombre',
        'descripcion',
        'tipo',
        'coordenadas',
        'latitud',
        'longitud',
        'radio',
        'unidad_distancia',
        'color',
        'activa',
    ];
    
    protected $casts = [
        'activa' => 'boolean',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
        'radio' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    // NADA MÁS. SIN getCoordenadasArrayAttribute, SIN appends, SIN relaciones extra
}