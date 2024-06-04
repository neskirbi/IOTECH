<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\SuperUsuario;
class LoginController extends Controller
{
    function index(){
        return view('login.index');
    }

    function Ingresar(Request $request){

        $su = SuperUsuario::where([
            'mail' => $request->mail
        ])->first();

        if($su){
            if($request->pass!=$su->pass){
                return redirect('login')->with('error', '¡Error de contraseña!');
            }
            Auth::guard('superusuarios')->login($su);
            return redirect('/');
        }

        return redirect('login')->with('error', '¡Correo no registrado!');
    }
}
