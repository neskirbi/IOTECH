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
        $str = random_bytes(8);
        $str = base64_encode($str);
        $str = str_replace(["+", "/", "="], "", $str);
        $str = substr($str, 0, 8);
       

        if($administrador = Administrador::find($request->id)){
            $administrador->pass = '';
            $administrador->temp = $str;
            $administrador->save();
            return array('status'=>1,$administrador);
        }

        if($operador = Operador::find($request->id)){
            $operador->pass = '';
            $operador->temp = $str;
            $operador->save();
            return array('status'=>1,$operador);
        }
        
        return array('status'=>0,array());
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
