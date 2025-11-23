<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(10);
        return Inertia::render('Productos/Index', [
            'productos' => $productos,
        ]);
    }

    public function create()
    {
        return Inertia::render('Productos/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'nullable|string|max:50',
            'unidad_medida' => 'nullable|string|max:20',
            'precio_unitario' => 'nullable|numeric',
            'stock' => 'nullable|integer',
        ]);

        Producto::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    public function show(Producto $producto)
    {
        return Inertia::render('Productos/Show', [
            'producto' => $producto,
        ]);
    }

    public function edit(Producto $producto)
    {
        return Inertia::render('Productos/Edit', [
            'producto' => $producto,
        ]);
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'nullable|string|max:50',
            'unidad_medida' => 'nullable|string|max:20',
            'precio_unitario' => 'nullable|numeric',
            'stock' => 'nullable|integer',
        ]);

        $producto->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }
}
