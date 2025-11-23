<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Edit, Plus } from 'lucide-vue-next';

interface Props {
    clientes: any;
}

defineProps<Props>();

const deleteCliente = (id: number) => {
    if (confirm('¿Estás seguro de eliminar este cliente?')) {
        router.delete(`/clientes/${id}`);
    }
};
</script>

<template>
    <Head title="Clientes" />
    <AppLayout>
        <div class="space-y-6 p-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">Clientes</h1>
                <Link href="/clientes/create" class="inline-block">
                    <Button>
                        <Plus class="mr-2 h-4 w-4" />
                        Nuevo Cliente
                    </Button>
                </Link>
            </div>

            <div class="rounded-lg border overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-100 dark:bg-slate-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Teléfono</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Dirección</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="cliente in clientes.data" :key="cliente.id" class="hover:bg-slate-50 dark:hover:bg-slate-900">
                            <td class="px-6 py-4 font-medium">{{ cliente.nombre }}</td>
                            <td class="px-6 py-4">{{ cliente.email }}</td>
                            <td class="px-6 py-4">{{ cliente.telefono || '-' }}</td>
                            <td class="px-6 py-4">{{ cliente.direccion || '-' }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <Link :href="`/clientes/${cliente.id}/edit`" class="inline-block">
                                    <Button variant="outline" size="sm">
                                        <Edit class="h-4 w-4" />
                                    </Button>
                                </Link>
                                <Button
                                    variant="outline"
                                    size="sm"
                                    @click="deleteCliente(cliente.id)"
                                >
                                    <Trash2 class="h-4 w-4 text-red-500" />
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="clientes.links" class="flex justify-center gap-2">
                <template v-for="link in clientes.links" :key="link.url">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        :class="[
                            'px-3 py-2 rounded border',
                            link.active
                                ? 'bg-blue-500 text-white'
                                : 'bg-white text-blue-500 hover:bg-gray-100 dark:bg-slate-800 dark:hover:bg-slate-700',
                        ]"
                    >
                        {{ link.label.replace(/<[^>]*>/g, '') }}
                    </Link>
                    <span v-else :class="[
                        'px-3 py-2 rounded border',
                        'cursor-not-allowed opacity-50 bg-gray-100 dark:bg-slate-900'
                    ]">
                        {{ link.label.replace(/<[^>]*>/g, '') }}
                    </span>
                </template>
            </div>
        </div>
    </AppLayout>
</template>
