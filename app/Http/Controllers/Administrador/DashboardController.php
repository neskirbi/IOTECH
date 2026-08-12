<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $adminId = GetId();

    // 1. Contadores principales para las tarjetas
    $totalEquipos = DB::table('equipos')->where('id_administrador', '=', $adminId)->count();
    $equiposActivos = DB::table('equipos')->where('activo', 1)->where('id_administrador', '=', $adminId)->count();
    $totalOperadores = DB::table('operadores')->where('activo', 1)->where('id_administrador', '=', $adminId)->count();
    $totalGeocercas = DB::table('geocercas')->where('activa', 1)->where('id_administrador', '=', $adminId)->count();

    // 2. Cajas Abiertas - Obtener solo los últimos estados de cada MAC y filtrar cerrado = 0
    // 2. Cajas Abiertas - Versión con WHERE EXISTS (más robusta)
$totalCajasAbiertas = DB::table('equipos')
    ->where('id_administrador', $adminId)
    ->where('activo', 1)
    ->whereExists(function($query) {
        $query->select(DB::raw(1))
              ->from('equipo_estados as e2')
              ->whereRaw('e2.mac = equipos.mac')
              ->where('e2.cerrado', 0)
              ->whereRaw('e2.datetime = (
                  SELECT MAX(datetime) 
                  FROM equipo_estados as e3 
                  WHERE e3.mac = equipos.mac
              )');
    })
    ->count();

    // 3. Registros de los últimos 7 días (por MAC)
    $registrosPorDia = DB::table('equipos')
        ->join('registros', 'equipos.mac', '=', 'registros.mac')
        ->leftJoin('operadores', 'registros.id_operador', '=', 'operadores.id')
        ->where('equipos.id_administrador', '=', $adminId)
        ->select(DB::raw('DATE(registros.created_at) as fecha'), DB::raw('count(registros.id) as total'))
        ->groupBy('fecha')
        ->orderBy('fecha', 'DESC')
        ->limit(7)
        ->get()
        ->reverse();

    // 4. Distribución de opciones ejecutadas (por MAC)
    $registrosPorOpcion = DB::table('equipos')
        ->join('registros', 'equipos.mac', '=', 'registros.mac')
        ->leftJoin('operadores', 'registros.id_operador', '=', 'operadores.id')
        ->where('equipos.id_administrador', '=', $adminId)
        ->select('registros.opcion', DB::raw('count(registros.id) as total'))
        ->groupBy('registros.opcion')
        ->get();

    // 5. Últimos eventos registrados (por MAC, con operador o administrador)
    $ultimosRegistros = DB::table('equipos')
        ->join('registros', 'equipos.mac', '=', 'registros.mac')
        ->leftJoin('operadores', 'registros.id_operador', '=', 'operadores.id')
        ->leftJoin('administradores', 'registros.id_operador', '=', 'administradores.id')
        ->where('equipos.id_administrador', '=', $adminId)
        ->select(
            'registros.id',
            'registros.mac',
            'registros.opcion',
            'registros.created_at',
            DB::raw("CASE 
                WHEN operadores.id IS NOT NULL THEN CONCAT(operadores.nombres, ' ', operadores.apellidos)
                WHEN administradores.id IS NOT NULL THEN CONCAT(administradores.nombres, ' ', administradores.apellidos)
                ELSE 'Kiosco'
            END as operador_nombre")
        )
        ->orderBy('registros.created_at', 'DESC')
        ->limit(8)
        ->get();

    // Retornamos la vista con los datos actualizados
    return view('administradores.dashboard.index', compact(
        'totalEquipos',
        'equiposActivos',
        'totalOperadores',
        'totalGeocercas',
        'totalCajasAbiertas',
        'registrosPorDia',
        'registrosPorOpcion',
        'ultimosRegistros'
    ));
}
}