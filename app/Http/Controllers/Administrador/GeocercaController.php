<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Geocerca;

class GeocercaController extends Controller
{
    public function index()
    {
        $geocercas = Geocerca::where('id_administrador', GetId())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('administradores.geocercas.index', compact('geocercas'));
    }

    public function create()
    {
        return view('administradores.geocercas.create');
    }

    public function edit($id)
    {
        $geocerca = Geocerca::where('id', $id)
            ->where('id_administrador', GetId())
            ->firstOrFail();
            
        return view('administradores.geocercas.edit', compact('geocerca'));
    }

    public function store(Request $request)
    {
        
        // Validación básica
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:circular,poligono',
            'color' => 'nullable|string|max:7',
        ]);
        
        // Validación según tipo
        if ($request->tipo == 'circular') {
            $request->validate([
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
                'radio' => 'required|numeric|min:10',
            ]);
        } else {
            // Para polígono, validar que coordenadas sea un JSON válido
            $request->validate([
                'coordenadas' => 'required|string',
            ]);
            
            // Verificar que sea JSON válido
            $coordenadas = $request->coordenadas;
            $decoded = json_decode($coordenadas, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['coordenadas' => 'Las coordenadas no tienen un formato válido.'])->withInput();
            }
            
            // Verificar que sea un array y tenga al menos 3 puntos
            if (!is_array($decoded) || count($decoded) < 3) {
                return back()->withErrors(['coordenadas' => 'Un polígono necesita al menos 3 puntos.'])->withInput();
            }
        }

        try {
            $geocerca = new Geocerca();
            $geocerca->id = GetUuid();
            $geocerca->id_administrador = GetId();
            $geocerca->nombre = $request->nombre;
            $geocerca->descripcion = $request->descripcion;
            $geocerca->tipo = $request->tipo;
            $geocerca->color = $request->color ?? '#3B82F6';
            
            if ($request->tipo == 'circular') {
                $geocerca->latitud = $request->latitud;
                $geocerca->longitud = $request->longitud;
                $geocerca->radio = $request->radio;
                $geocerca->unidad_distancia = 'metros';
                $geocerca->coordenadas = null;
            } else {
                // Guardar el JSON string directamente como texto
                $geocerca->coordenadas = $request->coordenadas;
                $geocerca->latitud = null;
                $geocerca->longitud = null;
                $geocerca->radio = null;
                $geocerca->unidad_distancia = 'metros';
                
           
            }
            
            $geocerca->activa = true;
            
           
            $geocerca->save();

            return redirect()->route('geocercas.index')
                ->with('success', 'Geocerca creada correctamente');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al guardar la geocerca: ' . $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $geocerca = Geocerca::where('id', $id)
            ->where('id_administrador', GetId())
            ->firstOrFail();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'activa' => 'boolean'
        ]);
        
        // Validación según tipo
        if ($geocerca->tipo == 'circular') {
            $request->validate([
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
                'radio' => 'required|numeric|min:10',
            ]);
        } else {
            // Para polígono, validar que coordenadas sea un JSON válido
            if ($request->has('coordenadas')) {
                $coordenadas = $request->coordenadas;
                $decoded = json_decode($coordenadas, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return back()->withErrors(['coordenadas' => 'Las coordenadas no tienen un formato válido.'])->withInput();
                }
                
                if (!is_array($decoded) || count($decoded) < 3) {
                    return back()->withErrors(['coordenadas' => 'Un polígono necesita al menos 3 puntos.'])->withInput();
                }
            }
        }

        $geocerca->nombre = $request->nombre;
        $geocerca->descripcion = $request->descripcion;
        $geocerca->color = $request->color ?? '#3B82F6';
        $geocerca->activa = $request->has('activa') ? $request->activa : true;
        
        if ($geocerca->tipo == 'circular') {
            $geocerca->latitud = $request->latitud;
            $geocerca->longitud = $request->longitud;
            $geocerca->radio = $request->radio;
        } else {
            if ($request->has('coordenadas')) {
                $geocerca->coordenadas = $request->coordenadas;
            }
        }
        
        try {
            $geocerca->save();
            
            return redirect()->route('geocercas.index')
                ->with('success', 'Geocerca actualizada correctamente');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar la geocerca: ' . $e->getMessage()])->withInput();
        }
    }

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