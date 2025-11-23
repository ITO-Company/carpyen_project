<?php

namespace App\Http\Controllers;

use App\Models\PageVisit;
use Inertia\Inertia;
use Inertia\Response;

class PageVisitController extends Controller
{
    /**
     * Mostrar estadísticas de visitas de páginas
     */
    public function index(): Response
    {
        $pageVisits = PageVisit::getPageStatistics();

        return Inertia::render('PageVisitStatistics/Index', [
            'statistics' => $pageVisits,
            'totalVisits' => $pageVisits->sum('visit_count'),
        ]);
    }

    /**
     * Resetear contador de una página
     */
    public function reset(string $pageName)
    {
        PageVisit::where('page_name', $pageName)->update(['visit_count' => 0]);

        return redirect()->back()->with('message', 'Contador reiniciado');
    }

    /**
     * Resetear todos los contadores
     */
    public function resetAll()
    {
        PageVisit::query()->update(['visit_count' => 0]);

        return redirect()->back()->with('message', 'Todos los contadores han sido reiniciados');
    }
}
