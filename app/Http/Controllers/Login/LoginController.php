<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\SuperUsuario;
use App\Models\Administrador;
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


        $adm = Administrador::where([
            'mail' => $request->mail
        ])->first();

        if($adm){
            if($adm->temp!='' ){
                if($adm->temp==$request->pass){
                    return redirect(('newpass/'.$adm->id.'/'.$request->pass.''));
                }else{
                    return redirect('login')->with('error','Contraseña erronea.');
                }
                
            }
            if($request->pass!=$adm->pass){
                return redirect('login')->with('error', '¡Error de contraseña!');
            }
            Auth::guard('administradores')->login($adm);
            return redirect('/');
        }

        return redirect('login')->with('error', '¡Correo no registrado!');
    }

    function Logout(){
        if( Auth::guard('superusuarios')->check()){
            Auth::guard('superusuarios')->logout();
            return redirect('/');
        }

        if( Auth::guard('administradores')->check()){
            Auth::guard('administradores')->logout();
            return redirect('/');
        }
    }

    function NewPass($id_administrador,$temp){
        return$administrador = Administrador::find($id_administrador);
    }
}
