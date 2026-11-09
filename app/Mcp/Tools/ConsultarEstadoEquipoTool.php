<?php

namespace App\Mcp\Tools;

use Wizcoders\Mcp\Tool;
use Wizcoders\Mcp\Request;
use App\Models\Equipo;
use App\Models\EquipoEstado;

class ConsultarEstadoEquipoTool extends Tool
{
    public function description()
    {
        return 'Obtiene el último estado conocido (evento, latitud, longitud, fecha) de un equipo GPS mediante su MAC o número económico.';
    }

    public function handle(Request $request)
    {
        $validated = $request->validate([
            'mac'           => 'nullable|string|max:50',
            'numeconomico' => 'nullable|string|max:20',
        ]);

        if (empty($validated['mac']) && empty($validated['numeconomico'])) {
            return "Error: Debes proporcionar 'mac' o 'numeconomico'.";
        }

        $adminId = auth()->user()?->administrador_id ?? null;

        $equipoQuery = Equipo::query();
        if ($adminId) {
            $equipoQuery->where('id_administrador', $adminId);
        }

        if (!empty($validated['mac'])) {
            $equipoQuery->where('mac', $validated['mac']);
        } else {
            $equipoQuery->where('numeconomico', $validated['numeconomico']);
        }

        $equipo = $equipoQuery->first();

        if (!$equipo) {
            return "Error: No se encontró ningún equipo con los datos proporcionados.";
        }

        $ultimoEstado = EquipoEstado::where('mac', $equipo->mac)
            ->orderByDesc('datetime')
            ->first();

        if (!$ultimoEstado) {
            return "El equipo {$equipo->numeconomico} ({$equipo->mac}) no tiene estados registrados.";
        }

        $datos = [
            'equipo'       => $equipo->numeconomico,
            'mac'          => $equipo->mac,
            'evento'       => $ultimoEstado->evento,
            'estado'       => $ultimoEstado->estado,
            'latitud'      => (float) $ultimoEstado->latitud,
            'longitud'     => (float) $ultimoEstado->longitud,
            'fecha_evento' => $ultimoEstado->datetime
                ? \Carbon\Carbon::parse($ultimoEstado->datetime)->toIso8601String()
                : null,
            'activo'       => (bool) $equipo->activo,
        ];

        return json_encode($datos, JSON_PRETTY_PRINT);
    }
}