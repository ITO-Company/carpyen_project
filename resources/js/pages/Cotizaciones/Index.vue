<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Edit, Plus } from 'lucide-vue-next';

interface Props {
    cotizaciones: any;
}

defineProps<Props>();

const deleteCotizacion = (id: number) => {
    if (confirm('¿Estás seguro?')) {
        router.delete(`/cotizaciones/${id}`);
    }
};
</script>

<template>
    <Head title="Cotizaciones" />
    <AppLayout>
        <div class="space-y-6 p-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">Cotizaciones</h1>
                <Link href="/cotizaciones/create">
                    <Button><Plus class="mr-2 h-4 w-4" /> Nueva</Button>
                </Link>
            </div>
            <div class="rounded-lg border overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-100 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-3 text-left">Proyecto</th>
                            <th class="px-6 py-3 text-left">Total</th>
                            <th class="px-6 py-3 text-left">Estado</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="item in cotizaciones.data" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-900">
                            <td class="px-6 py-4">{{ item.proyecto?.nombre || '-' }}</td>
                            <td class="px-6 py-4">${{ item.total || 0 }}</td>
                            <td class="px-6 py-4">{{ item.estado || '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <Link :href="`/cotizaciones/${item.id}/edit`"><Button variant="outline" size="sm"><Edit class="h-4 w-4" /></Button></Link>
                                <Button variant="outline" size="sm" @click="deleteCotizacion(item.id)"><Trash2 class="h-4 w-4 text-red-500" /></Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
