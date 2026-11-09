<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use App\Models\Equipo;
use App\Models\EquipoEstado;

#[Description('Obtiene el último estado conocido (evento, latitud, longitud, fecha) de un equipo GPS mediante su MAC o número económico.')]
class ConsultarEstadoEquipoTool extends Tool
{
    public function schema(JsonSchema $schema): array
    {
        return [
            'mac' => $schema->string()
                ->description('Dirección MAC del equipo (ej. 44:1D:64:E2:D3:46)')
                ->required(),
            'numeconomico' => $schema->string()
                ->description('Número económico del equipo (alternativo a la MAC)'),
        ];
    }

    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'mac'           => 'nullable|string|max:50',
            'numeconomico' => 'nullable|string|max:20',
        ]);

        if (empty($validated['mac']) && empty($validated['numeconomico'])) {
            return Response::error('Debes proporcionar "mac" o "numeconomico".');
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
            return Response::error('No se encontró ningún equipo con los datos proporcionados.');
        }

        $ultimoEstado = EquipoEstado::where('mac', $equipo->mac)
            ->orderByDesc('datetime')
            ->first();

        if (!$ultimoEstado) {
            return Response::text("El equipo {$equipo->numeconomico} ({$equipo->mac}) no tiene estados registrados.");
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

        return Response::text(
            json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }
}