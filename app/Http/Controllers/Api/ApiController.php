<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Administrador;

class ApiController extends Controller
{
    function GenerarPass(Request $request){
        $str = random_bytes(8);
        $str = base64_encode($str);
        $str = str_replace(["+", "/", "="], "", $str);
        $str = substr($str, 0, 8);
       

        $administrador = Administrador::find($request->id_administrador);
        $administrador->pass = '';
        $administrador->temp = $str;
        $administrador->save();
        
        return array('status'=>1,$administrador);
    }
}
