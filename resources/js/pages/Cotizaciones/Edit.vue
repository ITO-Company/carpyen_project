<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

defineProps<{ cotizacion: any }>();

const form = useForm({});
const submit = () => { form.put(`/cotizaciones/${1}`); };
</script>
<template>
    <Head title="Editar Cotización" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Editar Cotización</h1>
                <Link href="/cotizaciones"><Button variant="outline">Volver</Button></Link>
            </div>
            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <p class="text-gray-600">Formulario en construcción...</p>
                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">Guardar</Button>
                    <Link href="/cotizaciones"><Button type="button" variant="outline">Cancelar</Button></Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
