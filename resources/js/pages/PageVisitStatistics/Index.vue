<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Eye, RotateCcw } from 'lucide-vue-next';

interface PageVisit {
  id: number;
  page_name: string;
  page_route: string;
  visit_count: number;
  last_visited_at: string | null;
}

interface Props {
  statistics: PageVisit[];
  totalVisits: number;
}

defineProps<Props>();

const page = usePage();

const resetAll = () => {
  if (confirm('¿Estás seguro de que deseas reiniciar todos los contadores?')) {
    router.post((page as any).props.url + '/page-visits/reset-all');
  }
};

const formatDate = (date: string | null) => {
  if (!date) return 'Nunca';
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};
</script>

<template>
  <Head title="Estadísticas de Visitas" />
  <AppLayout>
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Estadísticas de Visitas de Páginas</h1>
        <div class="flex gap-2">
          <Button @click="resetAll" variant="destructive" class="gap-2">
            <RotateCcw class="w-4 h-4" />
            Reiniciar Todo
          </Button>
          <Link href="/dashboard">
            <Button variant="outline">Volver</Button>
          </Link>
        </div>
      </div>

      <!-- Resumen General -->
      <div class="mb-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
        <div class="flex items-center gap-4">
          <Eye class="w-8 h-8 text-blue-500" />
          <div>
            <p class="text-sm text-slate-600 dark:text-slate-400">Total de Visitas</p>
            <p class="text-3xl font-bold">{{ totalVisits }}</p>
          </div>
        </div>
      </div>

      <!-- Tabla de Estadísticas -->
      <div class="bg-white dark:bg-slate-800 rounded-lg border overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-slate-100 dark:bg-slate-700 border-b">
              <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Página</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Ruta</th>
                <th class="px-6 py-3 text-right text-sm font-semibold">Visitas</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Última Visita</th>
                <th class="px-6 py-3 text-right text-sm font-semibold">Acciones</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <tr
                v-for="page in statistics"
                :key="page.id"
                class="hover:bg-slate-50 dark:hover:bg-slate-700 transition"
              >
                <td class="px-6 py-4 text-sm font-medium">{{ page.page_name }}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ page.page_route }}</td>
                <td class="px-6 py-4 text-sm text-right font-semibold">
                  <span class="inline-flex items-center gap-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full">
                    <Eye class="w-4 h-4" />
                    {{ page.visit_count }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm">{{ formatDate(page.last_visited_at) }}</td>
                <td class="px-6 py-4 text-sm text-right">
                  <Link :href="`${page.page_route}`" target="_blank">
                    <Button variant="ghost" size="sm" class="gap-1">
                      Ver
                    </Button>
                  </Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-if="statistics.length === 0" class="p-8 text-center text-slate-600 dark:text-slate-400">
          <p>No hay datos de visitas disponibles</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
