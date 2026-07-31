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
}
