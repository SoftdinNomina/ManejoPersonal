<?php

namespace App\Http\Controllers;

use App\Models\MaePais;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaePaisesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('DM_Paises/Index', ['paises' => MaePais::all(),]);
    }

    public function getPaises()
    {
        $maePais = MaePais::all();
        return response()->json($maePais, 200);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render(
            'DM_Paises/Form'
        );
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
            'pais' => 'required',
            'continente' => 'required',
            'activo' => 'required',
        ]);

        MaePais::create([
            'pais' => $request->pais,
            'codigo_alfa2' => $request->codigo_alfa2,
            'codigo_alfa3' => $request->codigo_alfa3,
            'codigo_numerico' => $request->codigo_numerico,
            'continente' => $request->continente,
            'activo' => $request->activo
        ]);
        // sleep(1);

        return redirect()->route('paises.index'); //->with('message', 'Pais Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaePais  $maePais
     * @return \Illuminate\Http\Response
     */
    public function show(MaePais $maePais)
    {
        //dd($maePais);
        return Inertia::render(
            'DM_Paises/Show',
            [
                'pais' => $maePais
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaePais  $maePais
     * @return \Illuminate\Http\Response
     */
    public function edit(MaePais $paise)
    {
        return inertia::render(
            'DM_Paises/Form',
            [
                'pais' => $paise
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaePais  $maePais
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaePais $paise)
    {
        $validateData = $request->validate([
            'pais' => 'required',
            'codigo_alfa2' => 'nullable',
            'codigo_alfa3' => 'nullable',
            'codigo_numerico' => 'nullable',
            'continente' => 'nullable',
            'activo' => 'required',
        ]);

        $paise->update($validateData);
        return redirect()->route('paises.index'); //->with('message', 'Pais Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaePais  $maePais
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaePais $paise)
    {
        $paise->delete();
        // sleep(1);

        return redirect()->route('paises.index'); //->with('message', 'Pais Delete Successfully');
    }
}