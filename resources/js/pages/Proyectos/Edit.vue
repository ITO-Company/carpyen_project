<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

interface Props {
    proyecto: any;
    clientes: any[];
}

const props = defineProps<Props>();

const form = useForm({
    nombre: props.proyecto.nombre,
    descripcion: props.proyecto.descripcion || '',
    ubicacion: props.proyecto.ubicacion || '',
    estado: props.proyecto.estado || 'Pendiente',
    id_cliente: props.proyecto.id_cliente || '',
});

const submit = () => {
    form.put(`/proyectos/${props.proyecto.id}`);
};
</script>

<template>
    <Head title="Editar Proyecto" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Editar Proyecto</h1>
                <Link href="/proyectos">
                    <Button variant="outline">Volver</Button>
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <div>
                    <label class="block text-sm font-medium mb-2">Nombre *</label>
                    <input
                        v-model="form.nombre"
                        type="text"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                        required
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Descripción</label>
                    <textarea
                        v-model="form.descripcion"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                        rows="4"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Ubicación</label>
                    <input
                        v-model="form.ubicacion"
                        type="text"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Cliente</label>
                    <select
                        v-model="form.id_cliente"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                    >
                        <option value="">Seleccionar cliente</option>
                        <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                            {{ cliente.nombre }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Estado</label>
                    <select
                        v-model="form.estado"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                    >
                        <option value="Pendiente">Pendiente</option>
                        <option value="En Progreso">En Progreso</option>
                        <option value="Completado">Completado</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                    </Button>
                    <Link href="/proyectos">
                        <Button type="button" variant="outline">Cancelar</Button>
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
