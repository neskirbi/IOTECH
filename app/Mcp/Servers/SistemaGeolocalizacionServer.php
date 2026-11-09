<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use App\Mcp\Tools\ConsultarEstadoEquipoTool;
use App\Mcp\Tools\ListarGeocercasTool;
use App\Mcp\Tools\HistorialEquipoTool;

#[Name('Sistema de Geolocalización')]
#[Instructions('Servidor para consultar la ubicación y estado de equipos GPS, geocercas y registros de eventos.')]
class SistemaGeolocalizacionServer extends Server
{
    protected array $tools = [
        ConsultarEstadoEquipoTool::class,
        ListarGeocercasTool::class,
        HistorialEquipoTool::class,
    ];
}