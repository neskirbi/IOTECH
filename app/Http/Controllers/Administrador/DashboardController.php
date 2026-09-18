<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // 2. Cajas Abiertas: primer filtro (solo apertura/cierre), luego el mas nuevo por MAC, luego contar abiertas
        $eventosAperturaCierre = DB::table('equipos')
            ->join('equipo_estados', 'equipos.mac', '=', 'equipo_estados.mac')
            ->where('equipos.id_administrador', '=', $adminId)
            ->where('equipos.activo', 1)
            ->whereIn('equipo_estados.evento', ['apertura', 'cierre'])
            ->select('equipo_estados.id', 'equipo_estados.mac', 'equipo_estados.evento', 'equipo_estados.datetime')
            ->get();

        $ultimoPorMac = $eventosAperturaCierre
            ->sortByDesc('datetime')
            ->groupBy('mac')
            ->map(function ($eventos) {
                return $eventos->first();
            });

        $totalCajasAbiertas = $ultimoPorMac
            ->where('evento', 'apertura')
            ->count();

        // 3. Ingresos de Dinero del dia actual
        //    Cuenta TODOS los eventos 'ingreso' del dia, sin importar el orden.
        $hoy = Carbon::now()->toDateString();

        $totalIngresos = DB::table('equipos')
            ->join('equipo_estados', 'equipos.mac', '=', 'equipo_estados.mac')
            ->where('equipos.id_administrador', '=', $adminId)
            ->where('equipo_estados.evento', '=', 'ingreso')
            ->whereDate('equipo_estados.datetime', '=', $hoy)
            ->count();

        // 4. Registros de los ultimos 7 dias (por MAC)
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

        // 5. Distribucion de opciones ejecutadas (por MAC)
        $registrosPorOpcion = DB::table('equipos')
            ->join('registros', 'equipos.mac', '=', 'registros.mac')
            ->leftJoin('operadores', 'registros.id_operador', '=', 'operadores.id')
            ->where('equipos.id_administrador', '=', $adminId)
            ->select('registros.opcion', DB::raw('count(registros.id) as total'))
            ->groupBy('registros.opcion')
            ->get();

        // 6. Ultimos eventos registrados (historial: ultimos 10)
        $ultimosRegistros = DB::table('equipos')
            ->join('equipo_estados', 'equipos.mac', '=', 'equipo_estados.mac')
            ->where('equipos.id_administrador', '=', $adminId)
            ->select(
                'equipo_estados.id',
                'equipo_estados.mac',
                'equipo_estados.evento',
                'equipo_estados.estado',
                'equipo_estados.datetime',
                'equipos.numeconomico',
                'equipos.matricula'
            )
            ->orderBy('equipo_estados.datetime', 'DESC')
            ->limit(10)
            ->get();

        return view('administradores.dashboard.index', compact(
            'totalEquipos',
            'equiposActivos',
            'totalOperadores',
            'totalGeocercas',
            'totalCajasAbiertas',
            'totalIngresos',
            'registrosPorDia',
            'registrosPorOpcion',
            'ultimosRegistros'
        ));
    }
}