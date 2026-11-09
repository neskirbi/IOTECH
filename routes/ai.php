<?php

use App\Mcp\Servers\SistemaGeolocalizacionServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/geolocalizacion', SistemaGeolocalizacionServer::class);