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

        // 2. Registros de los últimos 7 días (Iniciando en equipos -> registros -> operadores)
        $registrosPorDia = DB::table('equipos')
            ->join('registros', 'equipos.numeconomico', '=', 'registros.numeconomico')
            ->leftJoin('operadores', 'registros.id_operador', '=', 'operadores.id')
            ->where('equipos.id_administrador', '=', $adminId)
            ->select(DB::raw('DATE(registros.created_at) as fecha'), DB::raw('count(registros.id) as total'))
            ->groupBy('fecha')
            ->orderBy('fecha', 'DESC')
            ->limit(7)
            ->get()
            ->reverse();

        // 3. Distribución de opciones ejecutadas (Iniciando en equipos -> registros -> operadores)
        $registrosPorOpcion = DB::table('equipos')
            ->join('registros', 'equipos.numeconomico', '=', 'registros.numeconomico')
            ->leftJoin('operadores', 'registros.id_operador', '=', 'operadores.id')
            ->where('equipos.id_administrador', '=', $adminId)
            ->select('registros.opcion', DB::raw('count(registros.id) as total'))
            ->groupBy('registros.opcion')
            ->get();

        // 4. Últimos eventos registrados (Iniciando en equipos -> registros -> operadores con Kiosco si no hay operador)
        $ultimosRegistros = DB::table('equipos')
            ->join('registros', 'equipos.numeconomico', '=', 'registros.numeconomico')
            ->leftJoin('operadores', 'registros.id_operador', '=', 'operadores.id')
            ->where('equipos.id_administrador', '=', $adminId)
            ->select(
                'registros.id',
                'registros.numeconomico',
                'registros.opcion',
                'registros.created_at',
                DB::raw("COALESCE(operadores.nombres, 'Kiosco') as operador_nombre"),
                DB::raw("COALESCE(operadores.apellidos, '') as operador_apellido")
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
            'registrosPorDia',
            'registrosPorOpcion',
            'ultimosRegistros'
        ));
    }
}