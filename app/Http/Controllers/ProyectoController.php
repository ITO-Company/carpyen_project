<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectos = Proyecto::with(['cliente', 'user'])->paginate(10);
        return Inertia::render('Proyectos/Index', [
            'proyectos' => $proyectos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::all();
        return Inertia::render('Proyectos/Create', [
            'clientes' => $clientes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:proyectos,nombre',
            'descripcion' => 'nullable|string|max:500',
            'ubicacion' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:50',
            'id_cliente' => 'nullable|exists:clientes,id',
        ]);

        $validated['user_id'] = auth()->id();
        Proyecto::create($validated);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $proyecto)
    {
        $proyecto->load(['cliente', 'user', 'cotizaciones', 'cronogramas', 'planPagos']);
        return Inertia::render('Proyectos/Show', [
            'proyecto' => $proyecto,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyecto $proyecto)
    {
        $clientes = Cliente::all();
        return Inertia::render('Proyectos/Edit', [
            'proyecto' => $proyecto,
            'clientes' => $clientes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:proyectos,nombre,' . $proyecto->id,
            'descripcion' => 'nullable|string|max:500',
            'ubicacion' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:50',
            'id_cliente' => 'nullable|exists:clientes,id',
        ]);

        $proyecto->update($validated);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado exitosamente');
    }
}
