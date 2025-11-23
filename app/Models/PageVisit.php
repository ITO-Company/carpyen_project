<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageVisit extends Model
{
    protected $fillable = [
        'page_name',
        'page_route',
        'visit_count',
        'last_visited_at',
    ];

    protected $casts = [
        'last_visited_at' => 'datetime',
    ];

    /**
     * Incrementar el contador de visitas de una página
     */
    public static function recordVisit(string $pageName, string $pageRoute): self
    {
        $visit = self::firstOrCreate(
            ['page_name' => $pageName],
            [
                'page_route' => $pageRoute,
                'visit_count' => 0,
            ]
        );

        $visit->increment('visit_count');
        $visit->update(['last_visited_at' => now()]);

        return $visit;
    }

    /**
     * Obtener el contador de una página específica
     */
    public static function getVisitCount(string $pageName): int
    {
        return self::where('page_name', $pageName)->value('visit_count') ?? 0;
    }

    /**
     * Obtener todas las visitas con más de 0 registros
     */
    public static function getPageStatistics()
    {
        return self::where('visit_count', '>', 0)
            ->orderByDesc('visit_count')
            ->get();
    }
}
