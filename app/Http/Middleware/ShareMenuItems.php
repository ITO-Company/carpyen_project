<?php

namespace App\Http\Middleware;

use App\Models\MenuItem;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShareMenuItems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Compartir los ítems del menú con todas las páginas Inertia
        \Inertia\Inertia::share('menu', function () {
            return MenuItem::main()
                ->with('children')
                ->get();
        });

        return $next($request);
    }
}
