<template>
  <div class="p-4">
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-4 flex-1">
        <!-- Ícono o Drag Handle -->
        <div class="text-gray-400">
          <GripVertical class="w-5 h-5" />
        </div>
        
        <!-- Información del ítem -->
        <div class="flex-1">
          <h3 class="font-semibold text-gray-900 dark:text-white">{{ (item as any).label }}</h3>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ (item as any).name }}</p>
          <div class="mt-1 flex gap-2 flex-wrap">
            <span v-if="(item as any).icon" class="text-xs bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
              Ícono: {{ (item as any).icon }}
            </span>
            <span v-if="(item as any).route" class="text-xs bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded">
              Ruta: {{ (item as any).route }}
            </span>
            <span v-if="(item as any).href" class="text-xs bg-purple-100 dark:bg-purple-900 px-2 py-1 rounded">
              Enlace: {{ (item as any).href }}
            </span>
            <span v-if="!(item as any).is_active" class="text-xs bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-2 py-1 rounded">
              Inactivo
            </span>
          </div>
        </div>
      </div>

      <!-- Acciones -->
      <div class="flex gap-2">
        <Link 
          :href="`/menu-items/${(item as any).id}/edit`"
          class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded hover:bg-blue-100 dark:hover:bg-blue-800 transition"
        >
          <Pencil class="w-4 h-4" />
          Editar
        </Link>
        <button
          @click="deleteItem"
          class="inline-flex items-center gap-1 px-3 py-1 text-sm bg-red-50 dark:bg-red-900 text-red-600 dark:text-red-300 rounded hover:bg-red-100 dark:hover:bg-red-800 transition"
        >
          <Trash2 class="w-4 h-4" />
          Eliminar
        </button>
      </div>
    </div>

    <!-- Subítems -->
    <div v-if="(item as any).children && (item as any).children.length > 0" class="mt-4 ml-9 space-y-2 border-l-2 border-gray-200 dark:border-gray-700 pl-4">
      <div v-for="child in (item as any).children" :key="(child as any).id" class="flex items-center justify-between py-2">
        <div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ (child as any).label }}</p>
          <p class="text-xs text-gray-500 dark:text-gray-400">{{ (child as any).name }}</p>
        </div>
        <div class="flex gap-2">
          <Link 
            :href="`/menu-items/${(child as any).id}/edit`"
            class="text-xs px-2 py-1 bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded hover:bg-blue-100"
          >
            Editar
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { GripVertical, Pencil, Trash2 } from 'lucide-vue-next';
import { router, Link } from '@inertiajs/vue3';

const props = defineProps({
  item: Object,
});

const deleteItem = () => {
  if (confirm('¿Estás seguro de que deseas eliminar este ítem del menú?')) {
    router.delete(`/menu-items/${(props.item as any).id}`);
  }
};
</script>
