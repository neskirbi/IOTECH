<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Administrador;
use App\Models\Operador;
use App\Models\Registro;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    function GenerarPass(Request $request){
    // Lista de tablas a buscar (COMENTARIO: Agregar nuevas tablas aquí)
    $tablas = [
        'administrador' => 'App\Models\Administrador',
        'operador' => 'App\Models\Operador', 
        'cliente' => 'App\Models\Cliente'
        // COMENTARIO: Agregar nuevas líneas para nuevas tablas
        // 'nuevo_tipo' => 'App\Models\NuevoModelo',
    ];
    
    // Generar 8 caracteres alfanuméricos
    $str = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 8);
    
    // Buscar en todas las tablas
    foreach($tablas as $tipo => $modeloClass) {
        if(class_exists($modeloClass)) {
            $usuario = $modeloClass::find($request->id);
            if($usuario) {
                // Verificar que tenga campos mail y pass
                if(isset($usuario->mail) && isset($usuario->pass)) {
                    $usuario->pass = ''; // Limpiar pass anterior
                    $usuario->temp = $str;
                    $usuario->save();
                    
                    return response()->json([
                        'status' => 1,
                        'temp' => $str,
                        'tipo' => $tipo,
                        'nombre' => $usuario->nombres ?? $usuario->name ?? ''
                    ]);
                }
            }
        }
    }
    
    return response()->json([
        'status' => 0,
        'message' => 'Usuario no encontrado en ninguna tabla'
    ]);
}

    function GenerarCodigo(Request $request){
        //return $request;
        $registro = new Registro();

        $registro->id = GetUuid();
        $registro->id_operador = isset($request->user_id) ? $request->user_id : '';
        $registro->numeconomico = isset($request->numeconomico) ? $request->numeconomico : '';
        $registro->opcion = $request->opcion;
        $registro->save();

        $codigo='';
        $rango=0;
        switch(($request->opcion*1)){
            case 1:
                $rango = 15;
            break;

            
            case 2:
                $rango = 20;
            break;

            
            case 3:
                $rango = 25;
            break;


            
            case 4:
                $rango = 2;
            break;
        }

        //haseando
        $codigo = hash('sha256', $request->codent);
        //Extrayendo del 20 al 24 servicio y del 15 al 19 para el motor
        $codigo = substr($codigo,$rango,4);
        //String to e=hexadecimal
        $codigo = hex2bin(bin2hex($codigo));
        //Exadecimal to decimal
        $codigo = hexdec($codigo);
        return array('status'=>1,'codigo'=>$codigo);
    }


    public function Geocercas(Request $request)
    {
        try {
            // Validar datos de entrada
            $validator = Validator::make($request->all(), [
                'userId' => 'required|string',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'maxDistance' => 'sometimes|numeric|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Datos inválidos: ' . $validator->errors()->first()
                ], 400);
            }

            $userId = $request->userId;
            $userLat = $request->latitude;
            $userLng = $request->longitude;
            $maxDistance = $request->maxDistance ?? 5000; // 5km por defecto

            // 1. Primero buscar geocercas del usuario administrador
            $geofences = DB::table('geocercas')
                ->where('id_administrador', $userId)
                ->where('activa', true)
                ->get();

            // Si no tiene geocercas propias, buscar geocercas públicas o de otros administradores
            if ($geofences->isEmpty()) {
                $geofences = DB::table('geocercas')
                    ->where('activa', true)
                    ->take(50) // Limitar resultados
                    ->get();
            }

            $geofencesResultados = [];

            foreach ($geofences as $geofence) {
                $distance = null;
                $insideGeofence = false;

                if ($geofence->tipo == 'circular' && $geofence->latitud && $geofence->longitud && $geofence->radio) {
                    // Calcular distancia a geocerca circular
                    $distance = $this->calcularDistancia(
                        $userLat, 
                        $userLng, 
                        $geofence->latitud, 
                        $geofence->longitud
                    );
                    
                    // Convertir radio a metros si está en kilómetros
                    $radioMetros = $geofence->unidad_distancia == 'kilometros' 
                        ? $geofence->radio * 1000 
                        : $geofence->radio;
                    
                    $insideGeofence = ($distance <= $radioMetros);
                    
                } elseif ($geofence->tipo == 'poligono' && $geofence->coordenadas) {
                    // Verificar si está dentro del polígono
                    $polygon = json_decode($geofence->coordenadas, true);
                    
                    if (is_array($polygon) && !empty($polygon)) {
                        $insideGeofence = $this->puntoEnPoligono($userLat, $userLng, $polygon);
                        
                        // Calcular distancia al centroide del polígono
                        $centro = $this->calcularCentroide($polygon);
                        if ($centro) {
                            $distance = $this->calcularDistancia(
                                $userLat, 
                                $userLng, 
                                $centro['lat'], 
                                $centro['lng']
                            );
                        }
                    }
                }

                // Solo incluir geocercas dentro del rango máximo
                if ($distance === null || $distance <= $maxDistance) {
                    // Calcular distancia al borde más cercano
                    $distanceToEdge = $this->calcularDistanciaAlBorde(
                        $userLat, $userLng, $geofence, $distance
                    );

                    $geofencesResultados[] = [
                        'id' => $geofence->id,
                        'name' => $geofence->nombre,
                        'latitude' => $geofence->latitud,
                        'longitude' => $geofence->longitud,
                        'radius' => $geofence->tipo == 'circular' ? 
                            ($geofence->unidad_distancia == 'kilometros' ? $geofence->radio * 1000 : $geofence->radio) 
                            : null,
                        'type' => $geofence->tipo,
                        'distance_to_user' => $distance,
                        'distance_to_edge' => $distanceToEdge,
                        'inside_geofence' => $insideGeofence,
                        'color' => $geofence->color,
                        'description' => $geofence->descripcion,
                        'polygon_points' => $geofence->tipo == 'poligono' && $geofence->coordenadas 
                            ? json_decode($geofence->coordenadas, true) 
                            : null
                    ];
                }
            }

            // Ordenar por distancia (más cercana primero)
            usort($geofencesResultados, function($a, $b) {
                $distA = $a['distance_to_user'] ?? PHP_INT_MAX;
                $distB = $b['distance_to_user'] ?? PHP_INT_MAX;
                return $distA <=> $distB;
            });

            return response()->json([
                'status' => 1,
                'message' => count($geofencesResultados) . ' geocercas encontradas',
                'geofences' => $geofencesResultados
            ]);

        } catch (\Exception $e) {
            Log::error('Error en Geocercas: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 0,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    // ==================== MÉTODOS AUXILIARES ====================

    /**
     * Calcular distancia entre dos puntos en metros
     */
    private function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {
        if (!$lat1 || !$lon1 || !$lat2 || !$lon2) {
            return null;
        }

        $earthRadius = 6371000; // metros

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    /**
     * Verificar si un punto está dentro de un polígono (Algoritmo ray casting)
     */
    private function puntoEnPoligono($lat, $lng, $polygon)
    {
        if (!is_array($polygon) || count($polygon) < 3) {
            return false;
        }

        $n = count($polygon);
        $inside = false;

        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i][0] ?? $polygon[$i][0];
            $yi = $polygon[$i][1] ?? $polygon[$i][1];
            $xj = $polygon[$j][0] ?? $polygon[$j][0];
            $yj = $polygon[$j][1] ?? $polygon[$j][1];

            $intersect = (($yi > $lng) != ($yj > $lng))
                && ($lat < ($xj - $xi) * ($lng - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

    /**
     * Calcular centroide de un polígono
     */
    private function calcularCentroide($polygon)
    {
        if (!is_array($polygon) || empty($polygon)) {
            return null;
        }

        $n = count($polygon);
        $centroidLat = 0;
        $centroidLng = 0;

        foreach ($polygon as $point) {
            $centroidLat += $point[0];
            $centroidLng += $point[1];
        }

        return [
            'lat' => $centroidLat / $n,
            'lng' => $centroidLng / $n
        ];
    }

    /**
     * Calcular distancia al borde más cercano de la geocerca
     */
    private function calcularDistanciaAlBorde($userLat, $userLng, $geofence, $currentDistance)
    {
        if ($geofence->tipo == 'circular' && $geofence->radio) {
            // Para círculos: distancia al centro - radio
            $radioMetros = $geofence->unidad_distancia == 'kilometros' 
                ? $geofence->radio * 1000 
                : $geofence->radio;
            
            return max(0, $currentDistance - $radioMetros);
        }
        
        // Para polígonos, usamos la distancia al centroide como aproximación
        return $currentDistance;
    }
}
