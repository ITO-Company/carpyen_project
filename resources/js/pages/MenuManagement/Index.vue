<template>
  <AppLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold tracking-tight">Gestión de Menú</h1>
          <p class="text-gray-500 dark:text-gray-400 mt-2">Administra los ítems de navegación de tu aplicación</p>
        </div>
        <Link href="/menu-items/create" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
          <PlusIcon class="w-5 h-5" />
          Nuevo Ítem
        </Link>
      </div>

      <!-- Menu Items -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div v-if="(menuItems as any[]).length > 0" class="divide-y divide-gray-200 dark:divide-gray-700">
          <MenuItemRow v-for="item in (menuItems as any[])" :key="(item as any).id" :item="item" />
        </div>
        <div v-else class="p-8 text-center text-gray-500 dark:text-gray-400">
          <p>No hay ítems de menú. ¡Crea el primero!</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import MenuItemRow from '../../components/MenuItemRow.vue';
import { PlusIcon } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
  menuItems: Array,
});
</script>
