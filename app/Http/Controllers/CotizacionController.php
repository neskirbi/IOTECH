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

        $cotizacion = Cotizacion::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'tipo_solucion' => $request->tipo_solucion,
            'mensaje' => $request->mensaje,
            'terminos' => $request->terminos ? true : false,
        ]);

        $mensaje = "📋 NUEVA COTIZACIÓN\n\n" .
                "Nombre: " . $request->nombre . "\n" .
                "Email: " . $request->email . "\n" .
                "Teléfono: " . ($request->telefono ?? 'No especificado') . "\n" .
                "Solución: " . ($request->tipo_solucion ?? 'No especificada') . "\n" .
                "Mensaje: " . ($request->mensaje ?? 'Sin mensaje');

        $this->enviarWhatsApp($mensaje, '525533772392');

        return redirect()->back()->with('success', '✅ Cotización enviada con éxito. Te contactaremos pronto.');
    }

    public function enviarWhatsApp($mensaje, $telefono)
    {
        $url = "https://graph.facebook.com/v21.0/" . env('WHATSAPP_PHONE_NUMBER_ID') . "/messages";

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $telefono,
            'type' => 'text',
            'text' => ['body' => $mensaje]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . env('WHATSAPP_ACCESS_TOKEN'),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}