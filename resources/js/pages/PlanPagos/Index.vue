<template>
  <Head title="Planes de Pago" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <!-- Header -->
      <div class="flex justify-between items-center mb-2">
        <div>
          <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Planes de Pago</h1>
          <p class="text-slate-600 dark:text-slate-400 mt-1">Gestiona los planes de pago de los proyectos</p>
        </div>
        <Link
          href="/plan-pagos/create"
          class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Nuevo Plan
        </Link>
      </div>

      <!-- Success Message -->
      <div
        v-if="($page.props.flash as any)?.success"
        class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-lg"
      >
        {{ ($page.props.flash as any).success }}
      </div>

      <!-- Table -->
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
        <div v-if="plans.length > 0" class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
            <thead class="bg-slate-50 dark:bg-slate-900">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Proyecto
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Deuda Total
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Pagado
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Estado
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Pagos
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Acciones
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
              <tr
                v-for="plan in plans"
                :key="plan.id"
                class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors"
              >
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-slate-900 dark:text-white">
                    {{ plan.proyecto?.nombre || 'N/A' }}
                  </div>
                  <div class="text-xs text-slate-500 dark:text-slate-400">
                    ID: {{ plan.id }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm font-semibold text-slate-900 dark:text-white">
                    ${{ Number(plan.deuda_total).toFixed(2) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div>
                    <span class="text-sm font-medium text-green-600 dark:text-green-400">
                      ${{ Number(plan.pagado_total).toFixed(2) }}
                    </span>
                    <div class="w-24 h-2 bg-slate-200 dark:bg-slate-700 rounded-full mt-1 overflow-hidden">
                      <div
                        class="h-full bg-green-600 transition-all"
                        :style="{ width: getPercentage(plan.pagado_total, plan.deuda_total) + '%' }"
                      />
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="{
                      'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full':
                        true,
                      'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400':
                        plan.estado === 'completado',
                      'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400':
                        plan.estado === 'activo',
                      'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400':
                        plan.estado === 'pendiente',
                    }"
                  >
                    {{ plan.estado || 'N/A' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm">
                    <span class="font-medium text-slate-900 dark:text-white">{{ plan.numero_pagos }}</span>
                    <span class="text-slate-500 dark:text-slate-400"> cuota(s)</span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end gap-2">
                    <Link
                      :href="`/plan-pagos/${plan.id}`"
                      class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                    >
                      Ver
                    </Link>
                    <Link
                      :href="`/plan-pagos/${plan.id}/edit`"
                      class="text-amber-600 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-300 transition-colors"
                    >
                      Editar
                    </Link>
                    <button
                      @click="deletePlan(plan.id)"
                      class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                    >
                      Eliminar
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">No hay planes de pago</h3>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Comienza creando un nuevo plan de pago
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Plan {
  id: number;
  proyecto?: { nombre: string };
  deuda_total: number;
  pagado_total: number;
  estado: string;
  numero_pagos: number;
}

interface PlanPagosResponse {
  data?: Plan[];
}

const props = defineProps<{
  planPagos: PlanPagosResponse | Plan[];
}>();

const $page = usePage();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Planes de Pago',
    href: '/plan-pagos',
  },
];

const plans = computed(() => {
  if (Array.isArray(props.planPagos)) {
    return props.planPagos;
  }
  return props.planPagos.data || [];
});

const getPercentage = (pagado: number, deuda: number): number => {
  if (deuda === 0 || !deuda) return 0;
  return (pagado / deuda) * 100;
};

const deletePlan = (id: number) => {
  if (confirm('¿Estás seguro de que deseas eliminar este plan de pago?')) {
    router.delete(`/plan-pagos/${id}`);
  }
};
</script>
