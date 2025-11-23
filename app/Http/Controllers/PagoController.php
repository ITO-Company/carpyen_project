<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Cliente;
use App\Models\PlanPago;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['cliente', 'planPago'])->paginate(10);
        return Inertia::render('Pagos/Index', [
            'pagos' => $pagos,
        ]);
    }

    public function create()
    {
        $clientes = Cliente::all();
        $planPagos = PlanPago::all();
        return Inertia::render('Pagos/Create', [
            'clientes' => $clientes,
            'planPagos' => $planPagos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'nullable|date',
            'total' => 'nullable|numeric',
            'estado' => 'nullable|string|max:50',
            'id_cliente' => 'nullable|exists:clientes,id',
            'id_plan_pago' => 'nullable|exists:plan_pagos,id',
        ]);

        Pago::create($validated);

        return redirect()->route('pagos.index')->with('success', 'Pago creado exitosamente');
    }

    public function show(Pago $pago)
    {
        $pago->load(['cliente', 'planPago']);
        return Inertia::render('Pagos/Show', [
            'pago' => $pago,
        ]);
    }

    public function edit(Pago $pago)
    {
        $clientes = Cliente::all();
        $planPagos = PlanPago::all();
        return Inertia::render('Pagos/Edit', [
            'pago' => $pago,
            'clientes' => $clientes,
            'planPagos' => $planPagos,
        ]);
    }

    public function update(Request $request, Pago $pago)
    {
        $validated = $request->validate([
            'fecha' => 'nullable|date',
            'total' => 'nullable|numeric',
            'estado' => 'nullable|string|max:50',
            'id_cliente' => 'nullable|exists:clientes,id',
            'id_plan_pago' => 'nullable|exists:plan_pagos,id',
        ]);

        $pago->update($validated);

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado exitosamente');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado exitosamente');
    }
}
