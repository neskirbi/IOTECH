<?php

namespace App\Http\Controllers\SuperUsuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Administrador;
use App\Models\Empresa;

class AdministradorController extends Controller
{    
    
    
    public function __construct(){
        $this->middleware('sulog');
    }


    public function index(Request $filtros)
    {
        $administradores = Administrador::select('id','nombres','apellidos','mail','pass','temp','empresa as empresa_id',
        DB::RAW('(select empresa from empresas where id = administradores.empresa ) as empresa'))
        ->orderby('nombres','asc')
        ->orderby('apellidos','asc')
        ->get();
        $empresas = Empresa::orderby('empresa','asc')->where('empresa','like','%'.$filtros->administrador.'%')->get();
        return view('superusuario.administradores.index',['administradores'=>$administradores,'empresas'=>$empresas,'filtros'=>$filtros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(ValidarMail($request->mail)){
            return redirect('administradores')->with('error','Ingresar un correo diferente, con el que intentó ya está registrado.');
        }
        $administrador = new Administrador();
        $administrador->id = GetUuid();
        $administrador->nombres = $request->nombres;
        $administrador->apellidos = $request->apellidos;
        $administrador->empresa = $request->empresa;
        $administrador->mail = $request->mail;        
        $administrador->pass = '';
        $administrador->token = '';   
        $administrador->save();
        return redirect('administradores')->with('success','Datos Guardados.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(ValidarMail($request->mail)){
            return redirect('administradores')->with('error','Ingresar un correo diferente, con el que intentó ya está registrado.');
        }
        $administrador = Administrador::find($id);
        
        $administrador->nombres = $request->nombres;
        $administrador->apellidos = $request->apellidos;
        $administrador->empresa = $request->empresa;
        
        if(isset($request->mail))
        $administrador->mail = $request->mail;
        
        $administrador->save();
        return redirect('administradores')->with('success','Datos Guardados.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $administrador = Administrador::find($id);
        $administrador->delete();
        return redirect('administradores')->with('error','Registro Borrado.');

    }

    function BorrarAdmin($id){
        

        $administrador = Administrador::select('id','nombres','apellidos','mail','pass','empresa as empresa_id',
        DB::RAW('(select empresa from empresas where id = administradores.empresa ) as empresa'))
        ->orderby('nombres','asc')
        ->orderby('apellidos','asc')
        ->where('id',$id)
        ->first();


        return view('superusuario.administradores.destroy',['administrador'=>$administrador]);
    }
}
