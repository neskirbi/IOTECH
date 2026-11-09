<?php

namespace App\Mcp\Tools;

use Wizcoders\Mcp\Tool;
use Wizcoders\Mcp\Request;
use App\Models\Geocerca;

class ListarGeocercasTool extends Tool
{
    public function description()
    {
        return 'Lista las geocercas activas del administrador autenticado, con nombre, tipo, coordenadas (formato [lat, lng]) y radio.';
    }

    public function handle(Request $request)
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
                'tipo'             => $g->tipo, // 'poligono' | 'circular'
                'latitud'          => $g->latitud ? (float) $g->latitud : null,
                'longitud'         => $g->longitud ? (float) $g->longitud : null,
                'radio'            => $g->radio ? (float) $g->radio : null,
                'unidad_distancia' => $g->unidad_distancia,
                'coordenadas'      => $g->coordenadas ? json_decode($g->coordenadas, true) : null,
                'color'            => $g->color,
                'activa'           => (bool) $g->activa,
            ];
        });

        $resultado = [
            'total'     => $geocercas->count(),
            'geocercas' => $geocercas->all(),
        ];

        return json_encode($resultado, JSON_PRETTY_PRINT);
    }
}