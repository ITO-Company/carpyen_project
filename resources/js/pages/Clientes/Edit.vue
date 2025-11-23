<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

interface Props {
    cliente: any;
}

const props = defineProps<Props>();

const form = useForm({
    nombre: props.cliente.nombre,
    email: props.cliente.email,
    telefono: props.cliente.telefono || '',
    direccion: props.cliente.direccion || '',
});

const submit = () => {
    form.put(`/clientes/${props.cliente.id}`);
};
</script>

<template>
    <Head title="Editar Cliente" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Editar Cliente</h1>
                <Link href="/clientes">
                    <Button variant="outline">Volver</Button>
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <div>
                    <label class="block text-sm font-medium mb-2">Nombre</label>
                    <input
                        v-model="form.nombre"
                        type="text"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                        required
                    />
                    <span v-if="form.errors.nombre" class="text-red-500 text-sm">{{ form.errors.nombre }}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                        required
                    />
                    <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Teléfono</label>
                    <input
                        v-model="form.telefono"
                        type="text"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Dirección</label>
                    <input
                        v-model="form.direccion"
                        type="text"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white"
                    />
                </div>

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Guardando...' : 'Guardar Cambios' }}
                    </Button>
                    <Link href="/clientes">
                        <Button type="button" variant="outline">Cancelar</Button>
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
