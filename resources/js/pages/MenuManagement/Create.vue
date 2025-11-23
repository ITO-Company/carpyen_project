<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <Link href="/menu-items" class="text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 mb-4">
          <ChevronLeft class="w-4 h-4" />
          Volver a Gestión de Menú
        </Link>
        <h1 class="text-3xl font-bold tracking-tight">Crear Nuevo Ítem de Menú</h1>
      </div>

      <!-- Form -->
      <form @submit.prevent="submit" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-6">
        <!-- Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Nombre (identificador único)
          </label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="ej: clientes"
          />
        </div>

        <!-- Label -->
        <div>
          <label for="label" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Etiqueta (texto que aparece en el menú)
          </label>
          <input
            id="label"
            v-model="form.label"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="ej: Clientes"
          />
        </div>

        <!-- Icon -->
        <div>
          <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Ícono (nombre del ícono lucide-vue-next)
          </label>
          <input
            id="icon"
            v-model="form.icon"
            type="text"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="ej: Users, Settings, Home"
          />
          <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Consulta lucide-vue-next para nombres disponibles
          </p>
        </div>

        <!-- Route vs Href -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="route" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              Ruta (nombre de ruta Laravel)
            </label>
            <input
              id="route"
              v-model="form.route"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="ej: clientes.index"
            />
          </div>
          <div>
            <label for="href" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              O Enlace directo
            </label>
            <input
              id="href"
              v-model="form.href"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="ej: /clientes"
            />
          </div>
        </div>

        <!-- Parent Item -->
        <div>
          <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Menú Padre (opcional, para crear submenús)
          </label>
          <select
            id="parent_id"
            v-model="form.parent_id"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="">Sin padre (Menú principal)</option>
            <option v-for="item in (parentItems as any[])" :key="(item as any).id" :value="(item as any).id">
              {{ (item as any).label }}
            </option>
          </select>
        </div>

        <!-- Order -->
        <div>
          <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Orden
          </label>
          <input
            id="order"
            v-model="form.order"
            type="number"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="0"
          />
          <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Los ítems se ordenarán por este número (ascendente)
          </p>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
          <button
            type="submit"
            :disabled="processing"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition"
          >
            {{ processing ? 'Guardando...' : 'Crear Ítem' }}
          </button>
          <Link href="/menu-items" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            Cancelar
          </Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ChevronLeft } from 'lucide-vue-next';
import { useForm, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
  parentItems: Array,
});

const form = useForm({
  name: '',
  label: '',
  icon: '',
  route: '',
  href: '',
  parent_id: '',
  order: 0,
});

const processing: any = form.processing;

const submit = () => {
  form.post('/menu-items');
};
</script>
