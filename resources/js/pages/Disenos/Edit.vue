<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const form = useForm({});

const endpoints = {
    'disenos': '/disenos',
    'proveedores': '/proveedores',
    'plan-pagos': '/plan-pagos',
    'pagos': '/pagos',
    'cronogramas': '/cronogramas',
    'tareas': '/tareas',
    'evaluacion-servicios': '/evaluacion-servicios'
};
</script>

<template>
    <Head title="Editar" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Editar</h1>
                <Link href="/"><Button variant="outline">Volver</Button></Link>
            </div>
            <form class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <p class="text-gray-600 dark:text-gray-400">Formulario - En construcción</p>
                <Button type="submit">Guardar</Button>
            </form>
        </div>
    </AppLayout>
</template>
