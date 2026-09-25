<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\IngresoExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function ingresos(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin    = $request->input('fecha_fin');
        $equipos     = $request->input('equipos', []);

        $adminId = GetId();

        $query = DB::table('equipos')
            ->join('equipo_estados', 'equipos.mac', '=', 'equipo_estados.mac')
            ->where('equipos.id_administrador', $adminId)
            ->where('equipo_estados.evento', 'ingreso')
            ->whereDate('equipo_estados.datetime', '>=', $fechaInicio)
            ->whereDate('equipo_estados.datetime', '<=', $fechaFin)
            ->select(
                'equipos.numeconomico',
                'equipos.equipo',
                'equipos.matricula',
                'equipos.mac',
                'equipo_estados.datetime',
                'equipo_estados.estado',
                'equipo_estados.latitud',
                'equipo_estados.longitud'
            )
            ->orderBy('equipo_estados.datetime', 'ASC');

        if (!empty($equipos)) {
            $query->whereIn('equipos.mac', $equipos);
        }

        $registros = $query->get();

        $nombreArchivo = 'reporte_ingresos_' . $fechaInicio . '_a_' . $fechaFin . '.xlsx';

        return Excel::download(
            new IngresoExport($registros, $fechaInicio, $fechaFin),
            $nombreArchivo
        );
    }
}