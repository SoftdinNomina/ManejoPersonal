<?php

use App\Http\Controllers\MaeBarriosController;
use App\Http\Controllers\MaeCiudadesController;
use App\Http\Controllers\MaeDepartamentosController;
use App\Http\Controllers\MaePaisesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('paises', MaePaisesController::class);
    Route::resource('departamentos', MaeDepartamentosController::class);
    Route::resource('ciudades', MaeCiudadesController::class);
    Route::resource('barrios', MaeBarriosController::class);

    Route::get('getPaises', [MaePaisesController::class, 'getPaises'])->name('getPaises');
    Route::post('paises_import', [MaePaisesController::class, 'importExcel'])->name('paises_import');

    Route::get('getDepartamentos/{paisID}', [MaeDepartamentosController::class, 'getDepartamentos'])->name('getDepartamentos');
    Route::post('departamentos_import', [MaeDepartamentosController::class, 'importExcel'])->name('departamentos_import');

    Route::get('getCiudades/{departamentoID}', [MaeCiudadesController::class, 'getCiudades'])->name('getCiudades');
    Route::post('ciudades_import', [MaeCiudadesController::class, 'importExcel'])->name('ciudades_import');

    // Route::get('getBarrios/{barrioID}', [MaeBarriosController::class, 'getBarrios'])->name('getBarrios');
    Route::post('barrios_import', [MaeBarriosController::class, 'importExcel'])->name('barrios_import');
});
