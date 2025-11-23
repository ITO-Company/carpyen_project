<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with(['proyecto', 'user'])->paginate(10);
        return Inertia::render('Cotizaciones/Index', [
            'cotizaciones' => $cotizaciones,
        ]);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return Inertia::render('Cotizaciones/Create', [
            'proyectos' => $proyectos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_metro' => 'nullable|string|max:50',
            'costo_metro' => 'nullable|numeric',
            'cantidad_metro' => 'nullable|numeric',
            'costo_muebles' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'estado' => 'nullable|string|max:50',
            'numero_muebles' => 'nullable|integer',
            'comentarios' => 'nullable|string|max:500',
            'id_proyecto' => 'nullable|exists:proyectos,id',
        ]);

        $validated['user_id'] = auth()->id();
        Cotizacion::create($validated);

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización creada exitosamente');
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['proyecto', 'user', 'disenos']);
        return Inertia::render('Cotizaciones/Show', [
            'cotizacion' => $cotizacion,
        ]);
    }

    public function edit(Cotizacion $cotizacion)
    {
        $proyectos = Proyecto::all();
        return Inertia::render('Cotizaciones/Edit', [
            'cotizacion' => $cotizacion,
            'proyectos' => $proyectos,
        ]);
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        $validated = $request->validate([
            'tipo_metro' => 'nullable|string|max:50',
            'costo_metro' => 'nullable|numeric',
            'cantidad_metro' => 'nullable|numeric',
            'costo_muebles' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'estado' => 'nullable|string|max:50',
            'numero_muebles' => 'nullable|integer',
            'comentarios' => 'nullable|string|max:500',
            'id_proyecto' => 'nullable|exists:proyectos,id',
        ]);

        $cotizacion->update($validated);

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización actualizada exitosamente');
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();
        return redirect()->route('cotizaciones.index')->with('success', 'Cotización eliminada exitosamente');
    }
}
