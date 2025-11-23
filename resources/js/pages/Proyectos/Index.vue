<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Edit, Plus } from 'lucide-vue-next';

interface Props {
    proyectos: any;
}

defineProps<Props>();

const deleteProyecto = (id: number) => {
    if (confirm('¿Estás seguro de eliminar este proyecto?')) {
        router.delete(`/proyectos/${id}`);
    }
};
</script>

<template>
    <Head title="Proyectos" />
    <AppLayout>
        <div class="space-y-6 p-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">Proyectos</h1>
                <Link href="/proyectos/create" class="inline-block">
                    <Button>
                        <Plus class="mr-2 h-4 w-4" />
                        Nuevo Proyecto
                    </Button>
                </Link>
            </div>

            <div class="rounded-lg border overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-100 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Cliente</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Estado</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Ubicación</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="proyecto in proyectos.data" :key="proyecto.id" class="hover:bg-slate-50 dark:hover:bg-slate-900">
                            <td class="px-6 py-4 font-medium">{{ proyecto.nombre }}</td>
                            <td class="px-6 py-4">{{ proyecto.cliente?.nombre || '-' }}</td>
                            <td class="px-6 py-4">
                                <span :class="[
                                    'px-3 py-1 rounded-full text-sm font-medium',
                                    proyecto.estado === 'Completado' ? 'bg-green-100 text-green-800' :
                                    proyecto.estado === 'En Progreso' ? 'bg-blue-100 text-blue-800' :
                                    'bg-gray-100 text-gray-800'
                                ]">
                                    {{ proyecto.estado || '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ proyecto.ubicacion || '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <Link :href="`/proyectos/${proyecto.id}/edit`" class="inline-block">
                                    <Button variant="outline" size="sm">
                                        <Edit class="h-4 w-4" />
                                    </Button>
                                </Link>
                                <Button
                                    variant="outline"
                                    size="sm"
                                    @click="deleteProyecto(proyecto.id)"
                                >
                                    <Trash2 class="h-4 w-4 text-red-500" />
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
