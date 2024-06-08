<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Operador;

class OperadorController extends Controller
{

    public function __construct(){
        $this->middleware('adlog');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $operadores = Operador::where('id_administrador',GetId())->paginate(15);
        return view('administradores.operadores.index',['operadores'=>$operadores]);
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
        $operador->id_administrador=GetId();
        $operador->nombres = $request->nombres;
        $operador->apellidos = $request->apellidos;
        $operador->mail = $request->mail;        
        $operador->pass = '';
        $operador->token = '';   
        $operador->save();
        return redirect('operadores')->with('success','Datos Guardados.');
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
        
        $operador->nombres = $request->nombres;
        $operador->apellidos = $request->apellidos;
        
        if(isset($request->mail))
        $operador->mail = $request->mail;
        
        $operador->save();
        return redirect('operadores')->with('success','Datos Guardados.');
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

        return view('administradores.operadores.destroy',['operador'=>$operador]);
    }
}
