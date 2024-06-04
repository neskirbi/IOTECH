<?php

namespace App\Http\Controllers\SuperUsuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Empresa;

class EmpresaController extends Controller
{
    
    
    public function __construct(){
        $this->middleware('sulog');
    }

    
    public function index(Request $filtros)
    {
        $empresas = Empresa::orderby('empresa','asc')->where('empresa','like','%'.$filtros->empresa.'%')->paginate(20);
        return view('superusuario.empresas.index',['empresas'=>$empresas,'filtros'=>$filtros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superusuario.empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = new Empresa();
        $empresa->id = GetUuid();
        $empresa->empresa = $request->empresa;
        $empresa->razonsocial = $request->razonsocial;
        $empresa->token ='';
        $empresa->save();

        return redirect('empresas');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = Empresa::find($id);
        return view('superusuario.empresas.edit',['empresa'=>$empresa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $empresa = Empresa::find($id);
        $empresa->empresa = $request->empresa;
        $empresa->razonsocial = $request->razonsocial;
        $empresa->save();
        return redirect(url('empresas'))->with('success','Se guardaron los datos.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $empresa->delete();
        return redirect(url('empresas'))->with('danger','Se borraron los datos.');
    }

    public function BorrarEmpresa($id){
        $empresa = Empresa::find($id);
        return view('superusuario.empresas.destroy',['empresa'=>$empresa]);
    }
}
