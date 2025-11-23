<?php

namespace App\Http\Controllers;

use App\Models\Diseno;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DisenoController extends Controller
{
    public function index()
    {
        $disenos = Diseno::with(['cotizacion', 'user'])->paginate(10);
        return Inertia::render('Disenos/Index', [
            'disenos' => $disenos,
        ]);
    }

    public function create()
    {
        $cotizaciones = Cotizacion::all();
        return Inertia::render('Disenos/Create', [
            'cotizaciones' => $cotizaciones,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url_render' => 'nullable|string|max:500',
            'plano_laminado' => 'nullable|string|max:500',
            'aprobado' => 'nullable|boolean',
            'fecha_aprobacion' => 'nullable|date',
            'comentario' => 'nullable|string|max:500',
            'id_cotizacion' => 'nullable|exists:cotizacions,id',
        ]);

        $validated['user_id'] = auth()->id();
        Diseno::create($validated);

        return redirect()->route('disenos.index')->with('success', 'Diseño creado exitosamente');
    }

    public function show(Diseno $diseno)
    {
        $diseno->load(['cotizacion', 'user']);
        return Inertia::render('Disenos/Show', [
            'diseno' => $diseno,
        ]);
    }

    public function edit(Diseno $diseno)
    {
        $cotizaciones = Cotizacion::all();
        return Inertia::render('Disenos/Edit', [
            'diseno' => $diseno,
            'cotizaciones' => $cotizaciones,
        ]);
    }

    public function update(Request $request, Diseno $diseno)
    {
        $validated = $request->validate([
            'url_render' => 'nullable|string|max:500',
            'plano_laminado' => 'nullable|string|max:500',
            'aprobado' => 'nullable|boolean',
            'fecha_aprobacion' => 'nullable|date',
            'comentario' => 'nullable|string|max:500',
            'id_cotizacion' => 'nullable|exists:cotizacions,id',
        ]);

        $diseno->update($validated);

        return redirect()->route('disenos.index')->with('success', 'Diseño actualizado exitosamente');
    }

    public function destroy(Diseno $diseno)
    {
        $diseno->delete();
        return redirect()->route('disenos.index')->with('success', 'Diseño eliminado exitosamente');
    }
}
