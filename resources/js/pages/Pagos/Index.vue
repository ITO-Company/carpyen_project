<template>
  <Head title="Pagos" />
  
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

      <!-- Header -->
      <div class="flex justify-between items-center mb-2">
        <div>
          <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Pagos</h1>
          <p class="text-slate-600 dark:text-slate-400 mt-1">Registra y gestiona los pagos de los clientes</p>
        </div>
        <Link
          href="/pagos/create"
          class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
        >
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Nuevo Pago
        </Link>
      </div>

        <!-- Filters -->
        <div class="mb-6 bg-white dark:bg-slate-800 rounded-lg shadow p-4">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                Por Estado
              </label>
              <select
                v-model="filters.estado"
                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm"
              >
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="pagado">Pagado</option>
                <option value="atrasado">Atrasado</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                Por Plan
              </label>
              <select
                v-model="filters.planId"
                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm"
              >
                <option value="">Todos los planes</option>
                <option v-for="plan in allPlans" :key="plan.id" :value="plan.id">
                  Plan #{{ plan.id }}
                </option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                Por Cliente
              </label>
              <select
                v-model="filters.clientId"
                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm"
              >
                <option value="">Todos los clientes</option>
                <option v-for="client in allClients" :key="client.id" :value="client.id">
                  {{ client.nombre }}
                </option>
              </select>
            </div>
          </div>
        </div>

        <!-- Success Message -->
        <div
          v-if="($page.props.flash as any)?.success"
          class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-lg"
        >
          {{ ($page.props.flash as any).success }}
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4">
            <div class="text-sm text-slate-600 dark:text-slate-400">Total de Pagos</div>
            <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ totalStats.total }}</div>
          </div>
          <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4">
            <div class="text-sm text-slate-600 dark:text-slate-400">Pendientes</div>
            <div class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ totalStats.pendiente }}</div>
          </div>
          <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4">
            <div class="text-sm text-slate-600 dark:text-slate-400">Pagados</div>
            <div class="text-2xl font-bold text-green-600 dark:text-green-400 mt-1">{{ totalStats.pagado }}</div>
          </div>
          <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-4">
            <div class="text-sm text-slate-600 dark:text-slate-400">Total Monto</div>
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">
              ${{ Number(totalStats.monto).toFixed(2) }}
            </div>
          </div>
        </div>

      <!-- Table -->
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden">
        <div v-if="filteredPagos.length > 0" class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
            <thead class="bg-slate-50 dark:bg-slate-900">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Fecha
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Cliente
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Plan
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Monto
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Estado
                </th>
                <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                  Acciones
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
              <tr
                v-for="pago in filteredPagos"
                :key="pago.id"
                class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">
                  {{ formatDate(pago.fecha) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-slate-900 dark:text-white">
                    {{ pago.cliente?.nombre || 'N/A' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-slate-900 dark:text-white">
                    Plan #{{ pago.plan_pago?.id || 'N/A' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm font-semibold text-slate-900 dark:text-white">
                    ${{ Number(pago.total).toFixed(2) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    :class="{
                      'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full': true,
                      'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400':
                        pago.estado === 'pagado',
                      'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400':
                        pago.estado === 'pendiente',
                      'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400':
                        pago.estado === 'atrasado',
                    }"
                  >
                    {{ pago.estado }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end gap-2">
                    <Link
                      :href="`/pagos/${pago.id}`"
                      class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                    >
                      Ver
                    </Link>
                    <Link
                      :href="`/pagos/${pago.id}/edit`"
                      class="text-amber-600 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-300 transition-colors"
                    >
                      Editar
                    </Link>
                    <button
                      @click="deletePago(pago.id)"
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
          <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-white">No hay pagos</h3>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Comienza registrando un nuevo pago
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface Pago {
  id: number;
  fecha: string;
  total: number;
  estado: string;
  cliente?: { id?: number; nombre: string };
  plan_pago?: { id: number };
}

interface Plan {
  id: number;
}

interface Client {
  id: number;
  nombre: string;
}

interface IndexProps {
  pagos: Pago[];
  plans: Plan[];
  clients: Client[];
}

const props = defineProps<IndexProps>();
const $page = usePage();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Pagos',
    href: '/pagos',
  },
];

const filters = ref({
  estado: '',
  planId: '',
  clientId: '',
});

const filteredPagos = computed(() => {
  return props.pagos.filter((pago: Pago) => {
    if (filters.value.estado && pago.estado !== filters.value.estado) return false;
    if (filters.value.planId && pago.plan_pago?.id !== parseInt(filters.value.planId)) return false;
    if (filters.value.clientId && pago.cliente?.id !== parseInt(filters.value.clientId)) return false;
    return true;
  });
});

const allPlans = computed(() => props.plans);
const allClients = computed(() => props.clients);

const totalStats = computed(() => {
  return {
    total: filteredPagos.value.length,
    pendiente: filteredPagos.value.filter((p: Pago) => p.estado === 'pendiente').length,
    pagado: filteredPagos.value.filter((p: Pago) => p.estado === 'pagado').length,
    monto: filteredPagos.value.reduce((sum: number, p: Pago) => sum + (Number(p.total) || 0), 0),
  };
});

const formatDate = (date: string | null): string => {
  if (!date) return 'N/A';
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
};

const deletePago = (id: number) => {
  if (confirm('¿Estás seguro de que deseas eliminar este pago?')) {
    router.delete(`/pagos/${id}`);
  }
};
</script>
