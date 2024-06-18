<?php

use App\Models\SuperUsuario;
use App\Models\Administrador;
use App\Models\Cliente;
use App\Models\Operador;

function Memoria(){
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 0); 
    ini_set('post_max_size', '30G');
}

function Version(){
    return 5;
}

function GetUuid(){
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); 
    return str_replace("-","",vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)));
}


function ValidarMail($mail){
    
    if(SuperUsuario::where('mail',$mail)->first()){
        return true;
    }

    if(Administrador::where('mail',$mail)->first()){
        return true;
    }

    if(Cliente::where('mail',$mail)->first()){
        return true;
    }

    if(Operador::where('mail',$mail)->first()){
        return true;
    }

    
    return false;
}


function GetId(){
    $id='';

    if(Auth::guard('superusuarios')->check()){
        return Auth::guard('superusuarios')->user()->id;
    }

    if(Auth::guard('administradores')->check()){
        return Auth::guard('administradores')->user()->id;
    }

    if(Auth::guard('operadores')->check()){
        return Auth::guard('operadores')->user()->id;
    }
}



?>