<?php

namespace App\Http\Controllers;

use App\Models\MaePais;
use App\Models\MaeDepartamento;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class MaeDepartamentosController extends Controller
{

    public function index(Request $request)
    {
        $maeDepartamentos = MaeDepartamento::where('pais_id', $request->paisID)->orderBy('departamento')->get();
        $maePaises = MaePais::all();
        session()->put('byPaises', $request->paisID);
        return Inertia::render('DM_Departamentos/Index', [
            'departamentos' => $maeDepartamentos,
            'paises' => $maePaises,
            'paisID' => $request->paisID,
        ]);
    }

    public function getDepartamentos($paisID)
    {
        $maeDepartamentos = MaeDepartamento::where('pais_id', $paisID)->orderBy('departamento')->get();
        return response()->json($maeDepartamentos, 200);
    }

    public function create()
    {
        $paisNombre = MaePais::findOrFail(Session::get('byPaises'));
        return Inertia::render(
            'DM_Departamentos/Form',
            [
                'paisNombre' =>  $paisNombre->pais,
                'paisID' =>  $paisNombre->id
            ]
        );
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
}