<?php

namespace App\Http\Controllers;

use App\Imports\BarriosImport;
use App\Models\MaeBarrio;
use App\Models\MaeCiudad;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;


class MaeBarriosController extends Controller
{

    public function index(Request $request)
    {
        $maeBarrios = null;
        $paisID = 0;
        $departamentoID = 0;
        $ciudadID = 0;
        if ($request->ciudadID != null && $request->ciudadID > 0) {
            $maeBarrios = MaeBarrio::where('ciudad_id', $request->ciudadID)->orderBy('barrio')->get();
            $paisID = $request->paisID;
            $departamentoID = $request->departamentoID;
            $ciudadID = $request->ciudadID;
        }
        session()->put('byCiudad',  $ciudadID);
        session()->put('byDepartamento',  $departamentoID);
        session()->put('byPais',  $paisID);

        return Inertia::render('DM_Barrios/Index', [
            'barrios' => $maeBarrios,
            'paisID' => $paisID,
            'departamentoID' => $departamentoID,
            'ciudadID' => $ciudadID,
        ]);
    }

    // public function getBarrios($ciudadID)
    // {
    //     $maeBarrios = MaeBarrio::where('ciudad_id', $ciudadID)->orderBy('barrio')->get();
    //     session()->put('byCiudad', $ciudadID);
    //     return response()->json($maeBarrios, 200);
    // }

    public function create()
    {
        if ((Session::get('byCiudad')) != null && (Session::get('byCiudad')) > 0) {
            $ciudad = MaeCiudad::findOrFail(Session::get('byCiudad'));
            return Inertia::render(
                'DM_Barrios/Form',
                [
                    'paisNombre' => $ciudad->maeDepartamento->maePais->pais,
                    'paisID' => $ciudad->maeDepartamento->maePais->id,
                    'departamentoNombre' =>  $ciudad->maeDepartamento->departamento,
                    'departamentoID' => $ciudad->maeDepartamento->id,
                    'ciudadNombre' =>  $ciudad->ciudad,
                    'ciudadID' => $ciudad->id
                ]
            );
        }

        return back()->withErrors(['create' => 'Debe seleccionar la Ciudad']);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ciudad_id' => 'required',
                'barrio' => 'required',
            ]);

            $barrio = MaeBarrio::create([
                'ciudad_id' => $request->ciudad_id,
                'barrio' => $request->barrio,
                'activo' => $request->activo
            ]);
            return redirect()->route('barrios.index', ['ciudadID' => $barrio->ciudad_id, 'departamentoID' => $barrio->maeCiudad->departamento_id, 'paisID' => $barrio->maeCiudad->maeDepartamento->pais_id]);
        } catch (\Exception $exception) {
            return back()->withErrors(['create' => 'Acción No disponible']);
        }
    }

    public function show(MaeBarrio $barrio)
    {
        return Inertia::render(
            'DM_Barrios/Show',
            [
                'barrio' => $barrio
            ]
        );
    }

    public function edit(MaeBarrio $barrio)
    {
        return inertia::render(
            'DM_Barrios/Form',
            [
                'barrio' => $barrio,
                'ciudadNombre' =>  $barrio->maeCiudad->ciudad,
                'departamentoNombre' =>  $barrio->maeCiudad->maeDepartamento->departamento,
                'departamentoID' =>  $barrio->maeCiudad->departamento_id,
                'paisNombre' => $barrio->maeCiudad->maeDepartamento->maePais->pais,
                'paisID' => $barrio->maeCiudad->maeDepartamento->pais_id
            ]
        );
    }

    public function update(Request $request, MaeBarrio $barrio)
    {
        try {
            $validateData = $request->validate([
                'ciudad_id' => 'required',
                'barrio' => 'required',
                'activo' => 'required',
            ]);

            $barrio->update($validateData);
            return redirect()->route('barrios.index', ['ciudadID' => $barrio->ciudad_id, 'departamentoID' => $barrio->maeCiudad->departamento_id, 'paisID' => $barrio->maeCiudad->maeDepartamento->pais_id]);
        } catch (\Exception $exception) {
            return back()->withErrors(['update' => 'Acción No disponible']);
        }
    }

    public function destroy(MaeBarrio $barrio)
    {
        try {
            $barrio->delete();
            // return redirect()->route('barrios.index');
        } catch (\Exception $exception) {
            return back()->withErrors(['delete' => 'Acción No disponible']);
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => ['required'],
            'ciudadID' => ['required']
        ]);

        if ($request->hasFile('file')) {
            $import = new BarriosImport($request->ciudadID);
            $import->import($request->file);

            $filas = count($import->toArray($request->file)[0]);
            $erroresDIN = [];
            $errores = $import->errors();
            // dd($errores);
            if ($errores->count() > 0) {
                $cont = 0;
                foreach ($errores as $error) {
                    $erroresDIN[$cont] = ['mensaje' => $error->errorInfo[2], 'detalle' => $error->getMessage(), 'filas' => $filas];
                    $cont++;
                }
            }
            // dd(response()->json($erroresDIN));
            if (count($erroresDIN) > 0)
                return redirect()->back()->withErrors( ['data'=> response()->json($erroresDIN)->getContent()]);
            else
                return redirect()->back();
        }
    }
}