<?php

namespace App\Http\Controllers;

use App\Imports\DepartamentosImport;
use App\Models\MaePais;
use App\Models\MaeDepartamento;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class MaeDepartamentosController extends Controller
{

    public function index(Request $request)
    {
        $maeDepartamentos = null;
        $paisID = 0;
        if ($request->paisID != null && $request->paisID > 0) {
            $maeDepartamentos = MaeDepartamento::where('pais_id', $request->paisID)->orderBy('departamento')->get();
            $paisID = $request->paisID;
        }
        $maePaises = MaePais::orderBy('pais')->get();
        session()->put('byPaises', $paisID);
        return Inertia::render('DM_Departamentos/Index', [
            'departamentos' => $maeDepartamentos,
            'paises' => $maePaises,
            'paisID' => $paisID,
        ]);
    }

    public function getDepartamentos($paisID)
    {
        $maeDepartamentos = MaeDepartamento::where('pais_id', $paisID)->orderBy('departamento')->get();
        session()->put('byPaises', $paisID);
        return response()->json($maeDepartamentos, 200);
    }

    public function create()
    {
        if ((Session::get('byPaises')) != null && Session::get('byPaises') > 0) {
            $paisNombre = MaePais::findOrFail(Session::get('byPaises'));
            return Inertia::render(
                'DM_Departamentos/Form',
                [
                    'paisNombre' =>  $paisNombre->pais,
                    'paisID' =>  $paisNombre->id
                ]
            );
        }
        return redirect()->back()->withErrors(['create' => 'Debe seleccionar el País']);
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'pais_id' => 'required',
                'departamento' => 'required',
                'activo' => 'required',
            ]);

            MaeDepartamento::create([
                'pais_id' => $request->pais_id,
                'departamento' => $request->departamento,
                'codigodane' => $request->codigodane,
                'codigo_iso' => $request->codigo_iso,
                'activo' => $request->activo
            ]);
            return redirect()->route('departamentos.index', ['paisID' => $request->pais_id]);
        } catch (\Exception $exception) {
            return back()->withErrors(['create' => 'Acción No disponible']);
        }
    }

    public function show(MaeDepartamento $departamento)
    {
        return Inertia::render(
            'DM_Departamentos/Show',
            [
                'departamento' => $departamento
            ]
        );
    }


    public function edit(MaeDepartamento $departamento)
    {
        return inertia::render(
            'DM_Departamentos/Form',
            [
                'departamento' => $departamento,
                'paisNombre' =>  $departamento->maePais->pais
            ]
        );
    }

    public function update(Request $request, MaeDepartamento $departamento)
    {
        try {
            $validateData = $request->validate([
                'id' => 'required',
                'departamento' => 'required',
                'codigodane' => 'nullable',
                'codigo_iso' => 'nullable',
                'activo' => 'required',
            ]);
            $departamento->update($validateData);
            return redirect()->route('departamentos.index', ['paisID' => $departamento->pais_id]);
        } catch (\Exception $exception) {
            return back()->withErrors(['update' => 'Acción No disponible']);
        }
    }

    public function destroy(MaeDepartamento $departamento)
    {
        try {
            $departamento->delete();
            return redirect()->route('departamentos.index', ['paisID' => $departamento->pais_id]);
        } catch (\Exception $exception) {
            return back()->withErrors(['delete' => 'Acción No disponible']);
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => ['required'],
            'paisID' => ['required']
        ]);

        if ($request->hasFile('file')) {
            $import = new DepartamentosImport($request->paisID);
            $import->import($request->file);
            $filas = count($import->toArray($request->file)[0]);
            $erroresDIN = [];
            $errores = $import->errors();
            if ($errores->count() > 0) {
                $cont = 0;
                foreach ($errores as $error) {
                    $erroresDIN[$cont] = ['mensaje' => $error->errorInfo[2], 'detalle' => $error->getMessage(), 'filas' => $filas];
                    $cont++;
                }
            }

            if (count($erroresDIN) > 0)
                return redirect()->back()->withErrors([response()->json($erroresDIN, 200)->getContent()]);
            else
                return redirect()->back();
        }
    }
}
