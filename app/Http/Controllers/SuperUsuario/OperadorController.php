<?php

namespace App\Http\Controllers\SuperUsuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Administrador;
use App\Models\Operador;

class OperadorController extends Controller
{

    public function __construct(){
        $this->middleware('sulog');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $administradores = Administrador::join('empresas','empresas.id','=','administradores.empresa')
        ->select('administradores.id','administradores.nombres','administradores.apellidos','empresas.empresa')
        ->orderby('administradores.apellidos','asc')
        ->get();
        $operadores = Operador::select('id','nombres','apellidos','mail','pass','temp',
        DB::RAW("(select id from administradores where id=operadores.id_administrador) as id_admin"),
        DB::RAW("(select empresa from empresas where id=(select empresa from administradores where id=operadores.id_administrador)) as empresa"),
        DB::RAW("(select concat(apellidos,' ',nombres) from administradores where id=operadores.id_administrador) as administrador"))->paginate(15);
        return view('superusuario.operadores.index',['administradores'=>$administradores,'operadores'=>$operadores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            return redirect('operadores')->with('error','Ingresar un correo diferente, con el que intentó ya está registrado.');
        }
        $operador = new Operador();
        $operador->id = GetUuid();
        $operador->id_administrador=$request->administrador;
        $operador->nombres = $request->nombres;
        $operador->apellidos = $request->apellidos;
        $operador->mail = $request->mail;        
        $operador->pass = '';
        $operador->token = '';   
        $operador->save();
        return redirect('operadoress')->with('success','Datos Guardados.');
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
            return redirect('operadores')->with('error','Ingresar un correo diferente, con el que intentó ya está registrado.');
        }
        $operador = Operador::find($id);
        
        $operador->id_administrador=$request->administrador;
        $operador->nombres = $request->nombres;
        $operador->apellidos = $request->apellidos;
        
        if(isset($request->mail))
        $operador->mail = $request->mail;
        
        $operador->save();
        return redirect('operadoress')->with('success','Datos Guardados.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operador = Operador::find($id);
        $operador->delete();
        return redirect('operadores')->with('error','Registro Borrado.');
    }


    function BorrarOperador($id){        

        $operador = Operador::find($id);

        return view('superusuario.operadores.destroy',['operador'=>$operador]);
    }
}
