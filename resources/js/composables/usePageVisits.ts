import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

/**
 * Composable para acceder a estadísticas de visitas de páginas
 */
export function usePageVisits() {
  const page = usePage();

  /**
   * Obtener el nombre de la página actual
   */
  const currentPageName = computed(() => {
    const url = window.location.pathname;
    return generatePageName(url);
  });

  /**
   * Obtener el contador de visitas de la página actual
   */
  const currentPageVisits = computed(() => {
    return (page.props as any).pageVisits?.visit_count ?? 0;
  });

  /**
   * Obtener la última visita
   */
  const lastVisitedAt = computed(() => {
    return (page.props as any).pageVisits?.last_visited_at ?? null;
  });

  /**
   * Generar nombre limpio de la página
   */
  function generatePageName(path: string): string {
    // Eliminar IDs numéricos al final de la ruta
    path = path.replace(/\/\d+$/, '');
    // Eliminar barras al inicio y final
    path = path.replace(/^\/|\/$/g, '');

    if (!path) {
      return 'Dashboard';
    }

    const parts = path.split('/').map((part: string) => {
      // Singularizar (remover última 's' si existe)
      const singular = part.replace(/s$/, '');
      // Capitalizar y reemplazar guiones con espacios
      return singular.charAt(0).toUpperCase() + singular.slice(1).replace(/-/g, ' ');
    });

    return parts.join(' - ');
  }

  return {
    currentPageName,
    currentPageVisits,
    lastVisitedAt,
  };
}
