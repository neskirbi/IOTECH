<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Administrador;
use App\Models\Operador;
use App\Models\Registro;

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
        $registro->id_operador = $request->id_operador;
        $registro->numeconomico = $request->numeconomico;
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
}
