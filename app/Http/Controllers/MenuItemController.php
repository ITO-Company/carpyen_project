<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuItemController extends Controller
{
    /**
     * Mostrar el listado de ítems del menú
     */
    public function index()
    {
        $menuItems = MenuItem::with('children')
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return Inertia::render('MenuManagement/Index', [
            'menuItems' => $menuItems,
        ]);
    }

    /**
     * Mostrar el formulario para crear un nuevo ítem
     */
    public function create()
    {
        $parentItems = MenuItem::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return Inertia::render('MenuManagement/Create', [
            'parentItems' => $parentItems,
        ]);
    }

    /**
     * Guardar un nuevo ítem del menú
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:menu_items,name',
            'label' => 'required|string',
            'icon' => 'nullable|string',
            'route' => 'nullable|string',
            'href' => 'nullable|string',
            'parent_id' => 'nullable|integer|exists:menu_items,id',
            'order' => 'nullable|integer',
        ]);

        MenuItem::create($validated);

        return redirect()->route('menu-items.index')
            ->with('success', 'Ítem del menú creado exitosamente');
    }

    /**
     * Mostrar el formulario para editar un ítem
     */
    public function edit(MenuItem $menuItem)
    {
        $parentItems = MenuItem::whereNull('parent_id')
            ->where('is_active', true)
            ->where('id', '!=', $menuItem->id)
            ->orderBy('order')
            ->get();

        return Inertia::render('MenuManagement/Edit', [
            'menuItem' => $menuItem,
            'parentItems' => $parentItems,
        ]);
    }

    /**
     * Actualizar un ítem del menú
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:menu_items,name,' . $menuItem->id,
            'label' => 'required|string',
            'icon' => 'nullable|string',
            'route' => 'nullable|string',
            'href' => 'nullable|string',
            'parent_id' => 'nullable|integer|exists:menu_items,id',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $menuItem->update($validated);

        return redirect()->route('menu-items.index')
            ->with('success', 'Ítem del menú actualizado exitosamente');
    }

    /**
     * Eliminar un ítem del menú
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('menu-items.index')
            ->with('success', 'Ítem del menú eliminado exitosamente');
    }

    /**
     * Actualizar el orden de los ítems del menú (drag & drop)
     */
    public function updateOrder(Request $request)
    {
        $items = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($items['items'] as $item) {
            MenuItem::find($item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Orden actualizado exitosamente']);
    }

    /**
     * Obtener todos los ítems activos del menú (para el sidebar)
     */
    public function getActiveItems()
    {
        $menuItems = MenuItem::main()
            ->with('children')
            ->get();

        return response()->json($menuItems);
    }
}
