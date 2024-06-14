<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Administrador;
use App\Models\Operador;

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
        $codigo='';

        $codigo = hash('sha256', $request->codent);
        return array('status'=>1,'codigo'=>hexdec(hex2bin(bin2hex(substr($codigo,20,4)))));
    }
}
