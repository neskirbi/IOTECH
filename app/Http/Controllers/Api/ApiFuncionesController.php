<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Administrador;
use App\Models\Operador;
use App\Models\Registro;
use App\Models\Equipo;
use App\Models\EquipoEstado;
use App\Models\Geocerca;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiFuncionesController extends Controller
{
    

    

    public function ToggleOperadorStatus(Request $request)
    {
        $operador = DB::table('operadores')->where('id', $request->id)->first();

        if (!$operador) {
            return response()->json([
                'status' => 0,
                'message' => 'Operador no encontrado.'
            ]);
        }

        // Alternar entre 1 y 0
        $nuevoEstado = $operador->activo == 1 ? 0 : 1;

        DB::table('operadores')
            ->where('id', $request->id)
            ->update(['activo' => $nuevoEstado, 'updated_at' => now()]);

        return response()->json([
            'status' => 1,
            'activo' => $nuevoEstado,
            'message' => $nuevoEstado == 1 ? 'Operador activado con éxito.' : 'Operador desactivado con éxito.'
        ]);
    }


    public function ToggleEquipoStatus(Request $request)
    {
        $id = $request->input('id');
        
        // Buscar equipo o retornar error
        $equipo = Equipo::find($id);

        if (!$equipo) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        }

        // Invertir estado (1 a 0 / 0 a 1)
        $equipo->activo = ($equipo->activo == 1) ? 0 : 1;
        $equipo->save();

        return response()->json([
            'success' => true,
            'activo'   => $equipo->activo,
            'message'  => 'Estado del equipo actualizado correctamente'
        ]);
    }


    public function ObtenerUltimoEstadoEquipo($mac)
{
    // Obtiene el reporte más reciente de equipo_estados
    $estado = EquipoEstado::where('mac', $mac)
                ->latest('datetime')
                ->first();

    // Obtiene el registro más reciente de la tabla registros
    $registro = Registro::where('mac', $mac)
                ->latest('created_at')
                ->first();

    // Valores por defecto
    $cerrado = 1;
    $latitud = 0.00000000;
    $longitud = 0.00000000;
    $datetime = null;
    $latitud_registro = 0.00000000;
    $longitud_registro = 0.00000000;
    $fecha_registro = null;
    $geofence_id = null;
    $opcion = null;

    // Si existe estado, tomar sus valores
    if ($estado) {
        $cerrado = $estado->cerrado;
        $datetime = $estado->datetime;
    }

    // Si existe registro, tomar sus coordenadas
    if ($registro) {
        $latitud_registro = $registro->latitud ?? 0.00000000;
        $longitud_registro = $registro->longitud ?? 0.00000000;
        $fecha_registro = $registro->created_at;
        $geofence_id = $registro->geofence_id;
        $opcion = $registro->opcion;
    }

    return response()->json([
        'mac' => $mac,
        // Datos de equipo_estados
        'cerrado' => $cerrado,
        'datetime' => $datetime,
        // Datos de registros
        'latitud' => $latitud_registro,
        'longitud' => $longitud_registro,
        'fecha_registro' => $fecha_registro,
        'geofence_id' => $geofence_id,
        'opcion' => $opcion
    ]);
}


    // Método para toggle de estado (activar/desactivar)
    public function toggleStatus($id)
    {
         
        try {
            $geocerca = Geocerca::where('id', $id)
                ->firstOrFail();
            
            $geocerca->activa = !$geocerca->activa;
            $geocerca->save();
            
            return response()->json([
                'success' => true,
                'activa' => $geocerca->activa,
                'message' => $geocerca->activa ? 'Geocerca activada' : 'Geocerca desactivada'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado'
            ], 500);
        }
    }
}
