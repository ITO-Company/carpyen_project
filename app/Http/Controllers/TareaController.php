<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Cronograma;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::with(['cronograma', 'proyecto', 'user'])->paginate(10);
        return Inertia::render('Tareas/Index', [
            'tareas' => $tareas,
        ]);
    }

    public function create()
    {
        $cronogramas = Cronograma::all();
        $proyectos = Proyecto::all();
        return Inertia::render('Tareas/Create', [
            'cronogramas' => $cronogramas,
            'proyectos' => $proyectos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hora_inicio' => 'nullable|date_format:H:i:s',
            'hora_final' => 'nullable|date_format:H:i:s',
            'descripcion' => 'nullable|string|max:500',
            'estado' => 'nullable|string|max:50',
            'id_cronograma' => 'nullable|exists:cronogramas,id',
            'id_proyecto' => 'nullable|exists:proyectos,id',
        ]);

        $validated['user_id'] = auth()->id();
        Tarea::create($validated);

        return redirect()->route('tareas.index')->with('success', 'Tarea creada exitosamente');
    }

    public function show(Tarea $tarea)
    {
        $tarea->load(['cronograma', 'proyecto', 'user']);
        return Inertia::render('Tareas/Show', [
            'tarea' => $tarea,
        ]);
    }

    public function edit(Tarea $tarea)
    {
        $cronogramas = Cronograma::all();
        $proyectos = Proyecto::all();
        return Inertia::render('Tareas/Edit', [
            'tarea' => $tarea,
            'cronogramas' => $cronogramas,
            'proyectos' => $proyectos,
        ]);
    }

    public function update(Request $request, Tarea $tarea)
    {
        $validated = $request->validate([
            'hora_inicio' => 'nullable|date_format:H:i:s',
            'hora_final' => 'nullable|date_format:H:i:s',
            'descripcion' => 'nullable|string|max:500',
            'estado' => 'nullable|string|max:50',
            'id_cronograma' => 'nullable|exists:cronogramas,id',
            'id_proyecto' => 'nullable|exists:proyectos,id',
        ]);

        $tarea->update($validated);

        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada exitosamente');
    }

    public function destroy(Tarea $tarea)
    {
        $tarea->delete();
        return redirect()->route('tareas.index')->with('success', 'Tarea eliminada exitosamente');
    }
}
