<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;

class CotizacionController extends Controller
{
    public function enviar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'tipo_solucion' => 'nullable|string|max:100',
            'mensaje' => 'nullable|string',
            'terminos' => 'required|accepted',
        ]);

        Cotizacion::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'tipo_solucion' => $request->tipo_solucion,
            'mensaje' => $request->mensaje,
            'terminos' => $request->terminos ? true : false,
        ]);

        return redirect()->back()->with('success', '✅ Cotización enviada con éxito. Te contactaremos pronto.');
    }
}