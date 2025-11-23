<?php

namespace App\Http\Controllers;

use App\Models\Cronograma;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CronogramaController extends Controller
{
    public function index()
    {
        $cronogramas = Cronograma::with(['proyecto', 'user'])->paginate(10);
        return Inertia::render('Cronogramas/Index', [
            'cronogramas' => $cronogramas,
        ]);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return Inertia::render('Cronogramas/Create', [
            'proyectos' => $proyectos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date',
            'dias_estimados' => 'nullable|integer',
            'estado' => 'nullable|string|max:50',
            'id_proyecto' => 'nullable|exists:proyectos,id',
        ]);

        $validated['user_id'] = auth()->id();
        Cronograma::create($validated);

        return redirect()->route('cronogramas.index')->with('success', 'Cronograma creado exitosamente');
    }

    public function show(Cronograma $cronograma)
    {
        $cronograma->load(['proyecto', 'user', 'tareas']);
        return Inertia::render('Cronogramas/Show', [
            'cronograma' => $cronograma,
        ]);
    }

    public function edit(Cronograma $cronograma)
    {
        $proyectos = Proyecto::all();
        return Inertia::render('Cronogramas/Edit', [
            'cronograma' => $cronograma,
            'proyectos' => $proyectos,
        ]);
    }

    public function update(Request $request, Cronograma $cronograma)
    {
        $validated = $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date',
            'dias_estimados' => 'nullable|integer',
            'estado' => 'nullable|string|max:50',
            'id_proyecto' => 'nullable|exists:proyectos,id',
        ]);

        $cronograma->update($validated);

        return redirect()->route('cronogramas.index')->with('success', 'Cronograma actualizado exitosamente');
    }

    public function destroy(Cronograma $cronograma)
    {
        $cronograma->delete();
        return redirect()->route('cronogramas.index')->with('success', 'Cronograma eliminado exitosamente');
    }
}
