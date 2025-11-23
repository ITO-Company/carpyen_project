<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const form = useForm({
    tipo_metro: '',
    costo_metro: '',
    cantidad_metro: '',
    costo_muebles: '',
    total: '',
    estado: 'Pendiente',
    numero_muebles: '',
    comentarios: '',
    id_proyecto: '',
});

const submit = () => {
    form.post('/cotizaciones');
};
</script>

<template>
    <Head title="Crear Cotización" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Crear Cotización</h1>
                <Link href="/cotizaciones"><Button variant="outline">Volver</Button></Link>
            </div>
            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <div>
                    <label class="block text-sm font-medium mb-2">Tipo Metro</label>
                    <input v-model="form.tipo_metro" type="text" class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Costo Metro</label>
                        <input v-model="form.costo_metro" type="number" step="0.01" class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Cantidad Metro</label>
                        <input v-model="form.cantidad_metro" type="number" step="0.01" class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Costo Muebles</label>
                    <input v-model="form.costo_muebles" type="number" step="0.01" class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white" />
                </div>
                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">{{ form.processing ? 'Creando...' : 'Crear' }}</Button>
                    <Link href="/cotizaciones"><Button type="button" variant="outline">Cancelar</Button></Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
