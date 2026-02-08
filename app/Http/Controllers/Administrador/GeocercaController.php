<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Geocerca;

class GeocercaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        // Obtener las geocercas del administrador actual CON PAGINACIÓN
        $geocercas = Geocerca::where('id_administrador', GetId())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // 10 elementos por página

        // Retornar la vista con las geocercas
        return view('administradores.geocercas.index', compact('geocercas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        return view('administradores.geocercas.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'latitud' => 'required|numeric',
        'longitud' => 'required|numeric',
        'radio' => 'required|numeric|min:10',
        'color' => 'nullable|string|max:7',
    ]);

    $geocerca = new Geocerca();
    $geocerca->id = GetUuid();
    $geocerca->id_administrador = GetId();
    $geocerca->nombre = $request->nombre;
    $geocerca->descripcion = $request->descripcion;
    $geocerca->tipo = 'circular'; // Siempre circular
    $geocerca->color = $request->color ?? '#3B82F6';
    $geocerca->latitud = $request->latitud;
    $geocerca->longitud = $request->longitud;
    $geocerca->radio = $request->radio;
    $geocerca->unidad_distancia = 'metros';
    $geocerca->activa = true;
    $geocerca->save();

    return redirect()->route('geocercas.index')
        ->with('success', 'Geocerca creada correctamente');
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
        $geocerca = Geocerca::where('id', $id)
            ->where('id_administrador', GetId())
            ->firstOrFail();
            
        return view('administradores.geocercas.edit', compact('geocerca'));
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
        $geocerca = Geocerca::where('id', $id)
            ->where('id_administrador', GetId())
            ->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'radio' => 'required|numeric|min:10',
            'color' => 'nullable|string|max:7',
            'activa' => 'boolean'
        ]);

        $geocerca->nombre = $request->nombre;
        $geocerca->descripcion = $request->descripcion;
        $geocerca->latitud = $request->latitud;
        $geocerca->longitud = $request->longitud;
        $geocerca->radio = $request->radio;
        $geocerca->color = $request->color ?? '#3B82F6';
        $geocerca->activa = $request->has('activa') ? $request->activa : true;
        $geocerca->save();

        return redirect()->route('geocercas.index')
            ->with('success', 'Geocerca actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $geocerca = Geocerca::where('id', $id)
            ->where('id_administrador', GetId())
            ->firstOrFail();
        
        $geocerca->delete();

        return redirect()->route('geocercas.index')
            ->with('success', 'Geocerca eliminada correctamente');
    }
}
