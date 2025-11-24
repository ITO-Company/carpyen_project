<?php

namespace App\Http\Controllers;

use App\Models\PlanPago;
use App\Models\Pago;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanPagoController extends Controller
{
    public function index()
    {
        $planPagos = PlanPago::with(['proyecto', 'pagos'])->paginate(10);
        return Inertia::render('PlanPagos/Index', [
            'planPagos' => $planPagos,
        ]);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return Inertia::render('PlanPagos/Create', [
            'proyectos' => $proyectos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deuda_total' => 'nullable|numeric',
            'numero_deuda' => 'nullable|integer',
            'numero_pagos' => 'nullable|integer',
            'estado' => 'nullable|string|max:50',
            'id_proyecto' => 'required|exists:proyectos,id',
            'pagos' => 'nullable|array',
            'pagos.*.fecha' => 'nullable|date',
            'pagos.*.total' => 'nullable|numeric',
            'pagos.*.estado' => 'nullable|string|max:50',
        ]);

        $pagosData = $validated['pagos'] ?? [];
        unset($validated['pagos']);

        // Calcular totales
        $deudaTotal = 0;
        foreach ($pagosData as $pago) {
            $deudaTotal += $pago['total'] ?? 0;
        }

        // Crear el plan de pago
        $planPago = PlanPago::create([
            ...$validated,
            'deuda_total' => $deudaTotal,
            'pagado_total' => 0,
            'numero_pagos' => count($pagosData),
        ]);

        // Crear los pagos asociados
        $proyecto = $planPago->proyecto;
        foreach ($pagosData as $pagoData) {
            Pago::create([
                'fecha' => $pagoData['fecha'],
                'total' => $pagoData['total'],
                'estado' => $pagoData['estado'] ?? 'pendiente',
                'id_plan_pago' => $planPago->id,
                'id_cliente' => $proyecto->id_cliente,
            ]);
        }

        return redirect()->route('plan-pagos.index')->with('success', 'Plan de pago creado exitosamente');
    }

    public function show(PlanPago $planPago)
    {
        $planPago->load(['proyecto', 'pagos.cliente']);
        return Inertia::render('PlanPagos/Show', [
            'planPago' => $planPago,
        ]);
    }

    public function edit(PlanPago $planPago)
    {
        $planPago->load('pagos');
        $proyectos = Proyecto::all();
        return Inertia::render('PlanPagos/Edit', [
            'planPago' => $planPago,
            'proyectos' => $proyectos,
        ]);
    }

    public function update(Request $request, PlanPago $planPago)
    {
        $validated = $request->validate([
            'deuda_total' => 'nullable|numeric',
            'pagado_total' => 'nullable|numeric',
            'numero_deuda' => 'nullable|integer',
            'numero_pagos' => 'nullable|integer',
            'estado' => 'nullable|string|max:50',
            'id_proyecto' => 'nullable|exists:proyectos,id',
        ]);

        $planPago->update($validated);

        return redirect()->route('plan-pagos.index')->with('success', 'Plan de pago actualizado exitosamente');
    }

    public function destroy(PlanPago $planPago)
    {
        $planPago->delete();
        return redirect()->route('plan-pagos.index')->with('success', 'Plan de pago eliminado exitosamente');
    }
}
