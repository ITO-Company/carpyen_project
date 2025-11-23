<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        // Obtener datos de visitas de la página actual
        $pageName = $this->generatePageName($request->getPathInfo());
        $pageVisits = PageVisit::where('page_name', $pageName)->first();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'pageVisits' => $pageVisits ? [
                'page_name' => $pageVisits->page_name,
                'visit_count' => $pageVisits->visit_count,
                'last_visited_at' => $pageVisits->last_visited_at,
            ] : null,
        ];
    }

    /**
     * Generar nombre de página
     */
    private function generatePageName(string $path): string
    {
        $path = preg_replace('/\/\d+$/', '', $path);
        $path = trim($path, '/');

        if (empty($path)) {
            return 'Dashboard';
        }

        $parts = explode('/', $path);
        $parts = array_map(function ($part) {
            $singular = rtrim($part, 's');
            return ucfirst(str_replace('-', ' ', $singular));
        }, $parts);

        return implode(' - ', $parts);
    }
}
