<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Equipo;

class EquipoController extends Controller
{
    public function __construct(){
        $this->middleware('adlog');
    }

    public function index()
    {
        $equipos = Equipo::where('id_administrador', GetId())->get();

        // Último ingreso con coordenadas válidas por MAC (para el mapa grande)
        $ultimosIngresos = DB::table('equipo_estados')
            ->whereIn('mac', $equipos->pluck('mac'))
            ->where('evento', 'ingreso')
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->where('latitud', '!=', 0)
            ->where('longitud', '!=', 0)
            ->orderBy('datetime', 'DESC')
            ->get()
            ->groupBy('mac')
            ->map(function ($items) {
                return $items->first();
            })
            ->values();

        return view('administradores.equipos.index', [
            'equipos'         => $equipos,
            'ultimosIngresos' => $ultimosIngresos,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $existe = Equipo::where('mac', $request->mac)->exists();

        if ($existe) {
            return redirect('equipos')->with('error', 'La MAC ya está registrada.');
        }

        $equipo = new Equipo();
        $equipo->id               = GetUuid();
        $equipo->id_administrador = GetId();
        $equipo->numeconomico     = $request->numeconomico;
        $equipo->equipo           = $request->equipo;
        $equipo->mac              = $request->mac;
        $equipo->matricula        = $request->matricula;
        $equipo->save();

        return redirect('equipos')->with('success', 'Los datos se guardaron.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $equipo = Equipo::find($id);

        $equipo->numeconomico = $request->numeconomico;
        $equipo->equipo       = $request->equipo;
        $equipo->mac          = $request->mac;
        $equipo->matricula    = $request->matricula;
        $equipo->save();

        return redirect('equipos')->with('success', 'Los datos se guardaron.');
    }

    public function destroy($id)
    {
        $equipo = Equipo::find($id);
        $equipo->delete();
        return redirect('equipos')->with('error', 'Registro Borrado.');
    }

    public function BorrarEquipo($id){
        $equipo = Equipo::find($id);

        return view('administradores.equipos.destroy',['equipo'=>$equipo]);
    }
}