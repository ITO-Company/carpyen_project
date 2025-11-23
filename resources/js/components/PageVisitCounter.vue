<script setup lang="ts">
import { usePageVisits } from '@/composables/usePageVisits';
import { Eye } from 'lucide-vue-next';
import { computed } from 'vue';

const { currentPageVisits, lastVisitedAt } = usePageVisits();

/**
 * Formatear fecha a formato legible
 */
const formattedLastVisit = computed(() => {
  if (!lastVisitedAt.value) return null;

  try {
    const date = new Date(lastVisitedAt.value);
    return date.toLocaleDateString('es-ES', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    });
  } catch {
    return null;
  }
});
</script>

<template>
  <div
    class="flex items-center justify-center gap-2 py-3 px-4 text-xs text-slate-600 dark:text-slate-400 border-t dark:border-slate-700"
  >
    <Eye class="w-4 h-4" />
    <span>Visitas en esta página: <strong>{{ currentPageVisits }}</strong></span>
    <span v-if="formattedLastVisit" class="ml-2 text-slate-500 dark:text-slate-500">
      (Última: {{ formattedLastVisit }})
    </span>
  </div>
</template>
