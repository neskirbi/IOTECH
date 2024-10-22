<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Equipo;

class SoporteController extends Controller
{
    public function index(Request $filtros)
    {
        $equipos = Equipo::where('numeconomico','like','%'.$filtros->numeconomico.'%')
        ->orderby('numeconomico','asc')
        ->get();
        return view('administradores.soporte.index',['equipos'=>$equipos,'filtros'=>$filtros]);
    }
}