<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="mb-6">
        <Link href="/menu-items" class="text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1 mb-4">
          <ChevronLeft class="w-4 h-4" />
          Volver a Gestión de Menú
        </Link>
        <h1 class="text-3xl font-bold tracking-tight">Editar Ítem de Menú</h1>
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
          />
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
          />
        </div>

        <!-- Active -->
        <div class="flex items-center gap-3">
          <input
            id="is_active"
            v-model="form.is_active"
            type="checkbox"
            class="w-4 h-4 border-gray-300 rounded"
          />
          <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">
            Activo
          </label>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
          <button
            type="submit"
            :disabled="processing"
            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 transition"
          >
            {{ processing ? 'Guardando...' : 'Actualizar Ítem' }}
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

const props = defineProps({
  menuItem: Object,
  parentItems: Array,
});

const form = useForm({
  name: (props.menuItem as any)?.name || '',
  label: (props.menuItem as any)?.label || '',
  icon: (props.menuItem as any)?.icon || '',
  route: (props.menuItem as any)?.route || '',
  href: (props.menuItem as any)?.href || '',
  parent_id: (props.menuItem as any)?.parent_id || '',
  order: (props.menuItem as any)?.order || 0,
  is_active: (props.menuItem as any)?.is_active || true,
});

const processing: any = form.processing;

const submit = () => {
  form.put(`/menu-items/${(props.menuItem as any).id}`);
};
</script>
