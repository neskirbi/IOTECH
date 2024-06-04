<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Operador extends Authenticatable
{
    protected $table = 'operadores';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
