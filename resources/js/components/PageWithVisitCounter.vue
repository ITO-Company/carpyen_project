<script setup lang="ts">
import PageVisitCounter from '@/components/PageVisitCounter.vue';

interface Props {
  class?: string;
}

defineProps<Props>();
</script>

<template>
  <div class="flex flex-col min-h-screen">
    <div class="flex-1">
      <slot />
    </div>
    <footer class="border-t dark:border-slate-700 bg-white dark:bg-slate-800 mt-auto">
      <PageVisitCounter />
    </footer>
  </div>
</template>
