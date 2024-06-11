<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Equipo;

class EquipoController extends Controller
{
    public function __construct(){
        $this->middleware('adlog');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipos = Equipo::where('id_administrador',GetId())->get();
        return view('administradores.equipos.index',['equipos'=>$equipos]);
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
        $equipo = new Equipo();
        $equipo->id = GetUuid();
        $equipo->id_administrador=GetId();
        $equipo->numeconomico = $request->numeconomico;
        $equipo->mac = $request->mac;
        $equipo->matricula = $request->matricula; 
        $equipo->save();

        return redirect('equipos')->with('success','Los datos se guardaron.');
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
        $equipo = Equipo::find($id);
        
        $equipo->numeconomico = $request->numeconomico;
        $equipo->mac = $request->mac;
        $equipo->matricula = $request->matricula; 
        $equipo->save();

        return redirect('equipos')->with('success','Los datos se guardaron.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equipo = Equipo::find($id);
        $equipo->delete();
        return redirect('equipos')->with('error','Registro Borrado.');
    }

    public function BorrarEquipo($id){
        $equipo = Equipo::find($id);

        return view('administradores.equipos.destroy',['equipo'=>$equipo]);
    }
}
