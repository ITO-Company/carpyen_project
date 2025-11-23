<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
</script>
<template>
    <Head title="Formulario" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Crear</h1>
                <Link href="/"><Button variant="outline">Volver</Button></Link>
            </div>
            <div class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <p class="text-gray-600">Formulario - En construcción</p>
                <Button type="button">Crear</Button>
            </div>
        </div>
    </AppLayout>
</template>
