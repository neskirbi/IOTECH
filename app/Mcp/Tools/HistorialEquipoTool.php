<?php

namespace App\Mcp\Tools;

use Wizcoders\Mcp\Tool;
use Wizcoders\Mcp\Request;
use App\Models\Equipo;
use App\Models\EquipoEstado;

class HistorialEquipoTool extends Tool
{
    public function description()
    {
        return 'Obtiene el historial de eventos de un equipo en un rango de fechas (máx. 100 eventos más recientes). Las fechas se interpretan en UTC.';
    }

    public function handle(Request $request)
    {
        $validated = $request->validate([
            'mac'          => 'required|string',
            'fecha_inicio' => 'required|date_format:Y-m-d',
            'fecha_fin'    => 'required|date_format:Y-m-d|after_or_equal:fecha_inicio',
        ]);

        $adminId = auth()->user()?->administrador_id ?? null;

        $equipoQuery = Equipo::where('mac', $validated['mac']);
        if ($adminId) {
            $equipoQuery->where('id_administrador', $adminId);
        }
        $equipo = $equipoQuery->first();

        if (!$equipo) {
            return "Error: No se encontró un equipo con MAC {$validated['mac']}.";
        }

        $query = EquipoEstado::where('mac', $validated['mac'])
            ->whereBetween('datetime', [
                $validated['fecha_inicio'] . ' 00:00:00',
                $validated['fecha_fin']    . ' 23:59:59',
            ]);

        $total = (clone $query)->count();

        $historial = $query
            ->orderByDesc('datetime')
            ->limit(100)
            ->get(['evento', 'estado', 'latitud', 'longitud', 'datetime']);

        $eventos = $historial->map(fn ($e) => [
            'evento'   => $e->evento,
            'estado'   => $e->estado,
            'latitud'  => (float) $e->latitud,
            'longitud' => (float) $e->longitud,
            'fecha'    => $e->datetime
                ? \Carbon\Carbon::parse($e->datetime)->toIso8601String()
                : null,
        ])->all();

        $resultado = [
            'equipo'    => $equipo->numeconomico,
            'mac'       => $equipo->mac,
            'total'     => $total,
            'mostrados' => count($eventos),
            'truncado'  => $total > 100,
            'eventos'   => $eventos,
        ];

        return json_encode($resultado, JSON_PRETTY_PRINT);
    }
}