<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistorialExport;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $adminId = GetId();

        $query = DB::table('equipos')
            ->join('equipo_estados', 'equipos.mac', '=', 'equipo_estados.mac')
            ->where('equipos.id_administrador', '=', $adminId)
            ->select(
                'equipo_estados.id',
                'equipo_estados.mac',
                'equipo_estados.evento',
                'equipo_estados.estado',
                'equipo_estados.datetime',
                'equipos.numeconomico',
                'equipos.equipo',
                'equipos.matricula'
            );

        $this->aplicarFiltros($query, $request);

        $historial = $query->orderBy('equipo_estados.datetime', 'DESC')->paginate(50);

        return view('administradores.dashboard.historial', compact('historial'));
    }

    public function excel(Request $request)
    {
        $adminId = GetId();

        $query = DB::table('equipos')
            ->join('equipo_estados', 'equipos.mac', '=', 'equipo_estados.mac')
            ->where('equipos.id_administrador', '=', $adminId)
            ->select(
                'equipo_estados.id',
                'equipo_estados.mac',
                'equipo_estados.evento',
                'equipo_estados.estado',
                'equipo_estados.datetime',
                'equipos.numeconomico',
                'equipos.equipo',
                'equipos.matricula'
            );

        $this->aplicarFiltros($query, $request);

        $historial = $query->orderBy('equipo_estados.datetime', 'DESC')->get();

        $nombreArchivo = 'historial_eventos_' . Carbon::now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new HistorialExport($historial), $nombreArchivo);
    }

    private function aplicarFiltros($query, Request $request)
    {
        if ($request->filled('numeconomico')) {
            $query->where('equipos.numeconomico', 'like', '%' . $request->numeconomico . '%');
        }

        if ($request->filled('equipo')) {
            $query->where('equipos.equipo', 'like', '%' . $request->equipo . '%');
        }

        if ($request->filled('matricula')) {
            $query->where('equipos.matricula', 'like', '%' . $request->matricula . '%');
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('equipo_estados.datetime', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('equipo_estados.datetime', '<=', $request->fecha_fin);
        }
    }
}