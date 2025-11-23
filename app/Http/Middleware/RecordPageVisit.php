<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordPageVisit
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo registrar visitas en GET requests
        if ($request->isMethod('GET') && $request->getPathInfo() !== '/') {
            // Generar nombre de página limpio
            $pageName = $this->generatePageName($request->getPathInfo());
            $pageRoute = $request->getPathInfo();

            // Registrar visita en background
            PageVisit::recordVisit($pageName, $pageRoute);
        }

        return $response;
    }

    /**
     * Generar un nombre legible para la página
     */
    private function generatePageName(string $path): string
    {
        // Limpiar la ruta de parámetros
        $path = preg_replace('/\/\d+$/', '', $path); // Eliminar IDs al final
        $path = trim($path, '/');

        if (empty($path)) {
            return 'Dashboard';
        }

        // Convertir rutas como "/clientes/create" en "Clientes - Crear"
        $parts = explode('/', $path);
        $parts = array_map(function ($part) {
            // Singularizar y capitalizar
            $singular = rtrim($part, 's');
            return ucfirst(str_replace('-', ' ', $singular));
        }, $parts);

        return implode(' - ', $parts);
    }
}
