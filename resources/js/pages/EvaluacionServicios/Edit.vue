<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
defineProps<{ evaluacion: any }>();
</script>
<template>
    <Head title="Editar Evaluación" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <h1 class="mb-6 text-3xl font-bold">Editar Evaluación</h1>
            <div class="space-y-6 rounded-lg border bg-white p-6 dark:bg-slate-800">
                <p>Formulario en construcción</p>
                <Link href="/evaluacion-servicios"><Button variant="outline">Volver</Button></Link>
            </div>
        </div>
    </AppLayout>
</template>
