<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
const form = useForm({});
</script>
<template>
    <Head title="Crear Producto" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Crear Producto</h1>
                <Link href="/productos"><Button variant="outline">Volver</Button></Link>
            </div>
            <form @submit.prevent="form.post('/productos')" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <p class="text-gray-600">Formulario - En construcción</p>
                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">Crear</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
