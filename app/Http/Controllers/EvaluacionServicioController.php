<?php

namespace App\Http\Controllers;

use App\Models\EvaluacionServicio;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluacionServicioController extends Controller
{
    public function index()
    {
        $evaluaciones = EvaluacionServicio::with('proyecto')->paginate(10);
        return Inertia::render('EvaluacionServicios/Index', [
            'evaluaciones' => $evaluaciones,
        ]);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return Inertia::render('EvaluacionServicios/Create', [
            'proyectos' => $proyectos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'comentarios' => 'nullable|string|max:500',
            'id_proyecto' => 'nullable|exists:proyectos,id',
            'calificacion_diseno' => 'nullable|integer|min:1|max:5',
            'calificacion_tela' => 'nullable|integer|min:1|max:5',
            'calificacion_instalacion' => 'nullable|integer|min:1|max:5',
        ]);

        EvaluacionServicio::create($validated);

        return redirect()->route('evaluacion-servicios.index')->with('success', 'Evaluación creada exitosamente');
    }

    public function show(EvaluacionServicio $evaluacionServicio)
    {
        $evaluacionServicio->load('proyecto');
        return Inertia::render('EvaluacionServicios/Show', [
            'evaluacion' => $evaluacionServicio,
        ]);
    }

    public function edit(EvaluacionServicio $evaluacionServicio)
    {
        $proyectos = Proyecto::all();
        return Inertia::render('EvaluacionServicios/Edit', [
            'evaluacion' => $evaluacionServicio,
            'proyectos' => $proyectos,
        ]);
    }

    public function update(Request $request, EvaluacionServicio $evaluacionServicio)
    {
        $validated = $request->validate([
            'comentarios' => 'nullable|string|max:500',
            'id_proyecto' => 'nullable|exists:proyectos,id',
            'calificacion_diseno' => 'nullable|integer|min:1|max:5',
            'calificacion_tela' => 'nullable|integer|min:1|max:5',
            'calificacion_instalacion' => 'nullable|integer|min:1|max:5',
        ]);

        $evaluacionServicio->update($validated);

        return redirect()->route('evaluacion-servicios.index')->with('success', 'Evaluación actualizada exitosamente');
    }

    public function destroy(EvaluacionServicio $evaluacionServicio)
    {
        $evaluacionServicio->delete();
        return redirect()->route('evaluacion-servicios.index')->with('success', 'Evaluación eliminada exitosamente');
    }
}
