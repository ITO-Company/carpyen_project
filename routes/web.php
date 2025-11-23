<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DisenoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\PlanPagoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\CronogramaController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EvaluacionServicioController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // CRUDs resources
    Route::resource('clientes', ClienteController::class);
    Route::resource('proyectos', ProyectoController::class);
    Route::resource('cotizaciones', CotizacionController::class);
    Route::resource('disenos', DisenoController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('plan-pagos', PlanPagoController::class);
    Route::resource('pagos', PagoController::class);
    Route::resource('cronogramas', CronogramaController::class);
    Route::resource('tareas', TareaController::class);
    Route::resource('evaluacion-servicios', EvaluacionServicioController::class);
});

require __DIR__.'/settings.php';
