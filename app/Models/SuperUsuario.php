<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperUsuario extends Authenticatable
{
    protected $table = 'superusuarios';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
