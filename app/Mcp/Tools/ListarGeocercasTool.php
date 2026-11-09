<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use App\Models\Geocerca;

#[Description('Lista las geocercas activas del administrador autenticado, con nombre, tipo, coordenadas (formato [lat, lng]) y radio.')]
class ListarGeocercasTool extends Tool
{
    public function schema(JsonSchema $schema): array
    {
        return [
            'solo_activas' => $schema->boolean()
                ->description('Si es true, devuelve solo geocercas activas (por defecto true)'),
        ];
    }

    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'solo_activas' => 'nullable|boolean',
        ]);

        $soloActivas = $validated['solo_activas'] ?? true;
        $adminId = auth()->user()?->administrador_id ?? null;

        $query = Geocerca::query();
        if ($adminId) {
            $query->where('id_administrador', $adminId);
        }
        if ($soloActivas) {
            $query->where('activa', 1);
        }

        $geocercas = $query->get([
            'id', 'nombre', 'descripcion', 'tipo',
            'latitud', 'longitud', 'radio', 'unidad_distancia',
            'coordenadas', 'color', 'activa',
        ])->map(function ($g) {
            return [
                'id'               => $g->id,
                'nombre'           => $g->nombre,
                'descripcion'      => $g->descripcion,
                'tipo'             => $g->tipo,
                'latitud'          => $g->latitud ? (float) $g->latitud : null,
                'longitud'         => $g->longitud ? (float) $g->longitud : null,
                'radio'            => $g->radio ? (float) $g->radio : null,
                'unidad_distancia' => $g->unidad_distancia,
                'coordenadas'      => $g->coordenadas ? json_decode($g->coordenadas, true) : null,
                'color'            => $g->color,
                'activa'           => (bool) $g->activa,
            ];
        });

        return Response::structured([
            'total'     => $geocercas->count(),
            'geocercas' => $geocercas->all(),
        ]);
    }
}