<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-vue-next';

defineProps<{ productos: any }>();
</script>

<template>
    <Head title="Productos" />
    <AppLayout>
        <div class="space-y-6 p-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">Productos</h1>
                <Link href="/productos/create"><Button><Plus class="mr-2 h-4 w-4" /> Nuevo</Button></Link>
            </div>
            <div class="bg-blue-50 dark:bg-slate-800 p-6 rounded-lg">
                <p>Lista de productos - CRUD en construcción</p>
            </div>
        </div>
    </AppLayout>
</template>
