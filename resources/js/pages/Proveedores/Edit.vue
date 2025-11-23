<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
defineProps<{ proveedor: any }>();
</script>
<template>
    <Head title="Editar Proveedor" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <h1 class="text-3xl font-bold mb-6">Editar Proveedor</h1>
            <div class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <p>Formulario - En construcción</p>
                <Link href="/proveedores"><Button variant="outline">Volver</Button></Link>
            </div>
        </div>
    </AppLayout>
</template>
