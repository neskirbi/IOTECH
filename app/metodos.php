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
    return 9;
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


function EnviarAfirebase($mac, $cerrado, $latitud = 0, $longitud = 0)
{
    try {
        // Buscar el equipo por MAC
        $equipo = DB::table('equipos')
            ->where('mac', $mac)
            ->first();

        if (!$equipo) {
            return ['success' => false, 'error' => 'Equipo no encontrado'];
        }

        // ============================================
        // 🔥 INICIALIZAR FIREBASE CON LA URL
        // ============================================
        $factory = (new \Kreait\Firebase\Factory)
            ->withServiceAccount(storage_path('app/public/firebase/oii-on-firebase.json'))
            ->withDatabaseUri('https://oii-on-default-rtdb.firebaseio.com/');
        
        $database = $factory->createDatabase();

        // Datos a enviar
        $data = [
            'mac' => strtolower($mac),
            'cerrado' => (int) $cerrado,
            'latitud' => (float) $latitud,
            'longitud' => (float) $longitud,
            'datetime' => now()->toISOString(),
            'numeconomico' => $equipo->numeconomico,
            'matricula' => $equipo->matricula,
            'equipo_id' => $equipo->id
        ];

        // Guardar en Firebase: /estados/{equipo_id}
        $database->getReference('estados/' . $equipo->id)->set($data);

        return ['success' => true];

    } catch (\Exception $e) {
        \Log::error('Firebase Error: ' . $e->getMessage());
        return ['success' => false, 'error' => $e->getMessage()];
    }
}



?>