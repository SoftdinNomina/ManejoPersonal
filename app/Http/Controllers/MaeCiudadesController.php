<?php

namespace App\Http\Controllers;

use App\Imports\CiudadesImport;
use App\Models\MaeCiudad;
use App\Models\MaeDepartamento;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;


class MaeCiudadesController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('DM_Ciudades/Index', [
            'paisID' => $request->paisID,
            'departamentoID' => $request->departamentoID,
        ]);
    }

    public function getCiudades($departamentoID)
    {
        $maeCiudades = MaeCiudad::where('departamento_id', $departamentoID)->orderBy('ciudad')->get();
        session()->put('byDepartamento',  $departamentoID);
        return response()->json($maeCiudades, 200);
    }

    public function create()
    {
        if ((Session::get('byDepartamento')) != null) {
            $departamento = MaeDepartamento::findOrFail(Session::get('byDepartamento'));
            return Inertia::render(
                'DM_Ciudades/Form',
                [
                    'paisNombre' => $departamento->maePais->pais,
                    'paisID' => $departamento->maePais->id,
                    'departamentoNombre' =>  $departamento->departamento,
                    'departamentoID' => $departamento->id
                ]
            );
        } else
        return back()->withErrors(['create' => 'Debe seleccionar el Departamento']);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'departamento_id' => 'required',
                'ciudad' => 'required',
                'activo' => 'required',
            ]);

            $ciudade =  MaeCiudad::create([
                'departamento_id' => $request->departamento_id,
                'ciudad' => $request->ciudad,
                'codigodane' => $request->codigodane,
                'activo' => $request->activo
            ]);
            return redirect()->route('ciudades.index', ['departamentoID' => $ciudade->departamento_id, 'paisID' => $ciudade->maeDepartamento->pais_id]);
        } catch (\Exception $exception) {
            return back()->withErrors(['create' => 'Acción No disponible']);
        }
    }

    public function show(MaeCiudad $ciudade)
    {
        return Inertia::render(
            'DM_Ciudades/Show',
            [
                'ciudad' => $ciudade
            ]
        );
    }

    public function edit(MaeCiudad $ciudade)
    {
        return inertia::render(
            'DM_Ciudades/Form',
            [
                'ciudad' => $ciudade,
                'departamentoNombre' =>  $ciudade->maeDepartamento->departamento,
                'paisNombre' => $ciudade->maeDepartamento->maePais->pais,
                'paisID' => $ciudade->maeDepartamento->pais_id
            ]
        );
    }

    public function update(Request $request, MaeCiudad $ciudade)
    {
        try {
            $validateData = $request->validate([
                'departamento_id' => 'required',
                'ciudad' => 'required',
                'codigodane' => 'nullable',
                'activo' => 'required',
            ]);

            $ciudade->update($validateData);
            return redirect()->route('ciudades.index', ['departamentoID' => $ciudade->departamento_id, 'paisID' => $ciudade->maeDepartamento->pais_id]);
        } catch (\Exception $exception) {
            return back()->withErrors(['update' => 'Acción No disponible']);
        }
    }

    public function destroy(MaeCiudad $ciudade)
    {
        try {
            $ciudade->delete();
            // return redirect()->route('ciudades.index', ['departamentoID' => $ciudade->departamento_id, 'paisID' => $ciudade->maeDepartamento->pais_id]);
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
            $import = new CiudadesImport();
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
            }else{
                $erroresDIN[0] = ['mensaje' => '', 'detalle' => '', 'filas' => $filas];
            }

            return redirect()->back()->withErrors([response()->json($erroresDIN, 200)->getContent()]);
        }
    }

}