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
        return Inertia::render('DM_Barrios/Index', [
            'paisID' => $request->paisID,
            'departamentoID' => $request->departamentoID,
            'ciudadID' => $request->ciudadID,
        ]);
    }

    public function getBarrios($ciudadID)
    {
        $maeBarrios = MaeBarrio::where('ciudad_id', $ciudadID)->orderBy('barrio')->get();
        session()->put('byCiudad', $ciudadID);
        return response()->json($maeBarrios, 200);
    }

    public function create()
    {
        if ((Session::get('byCiudad')) != null) {
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
        } else
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
            'file' => ['required']
        ]);

        if ($request->hasFile('file')) {
            $import = new BarriosImport();
            $import->import($request->file);

            $filas = count($import->toArray($request->file)[0]);
            $erroresDIN = [0];
            $errores = $import->errors();
            if ($errores->count() > 0) {
                $cont = 0;
                foreach ($errores as $error) {
                    $erroresDIN[$cont] = ['mensaje' => $error->errorInfo[2], 'detalle' => $error->getMessage(), 'filas' => $filas];
                    $cont++;
                }
            } else {
                $erroresDIN[0] = ['mensaje' => '', 'detalle' => '', 'filas' => $filas];
            }

            return redirect()->back()->withErrors([response()->json($erroresDIN, 200)->getContent()]);
        }
    }
}