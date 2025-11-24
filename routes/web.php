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
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PageVisitController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard con datos de pagos y planes
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');    // Menu Management
    Route::resource('menu-items', MenuItemController::class);
    Route::post('menu-items/update-order', [MenuItemController::class, 'updateOrder'])->name('menu-items.update-order');

    // Page Visit Statistics
    Route::get('page-visits', [PageVisitController::class, 'index'])->name('page-visits.index');
    Route::post('page-visits/{pageName}/reset', [PageVisitController::class, 'reset'])->name('page-visits.reset');
    Route::post('page-visits/reset-all', [PageVisitController::class, 'resetAll'])->name('page-visits.reset-all');

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
