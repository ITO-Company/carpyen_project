<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import FormField from '@/components/FormField.vue';
import { useFormValidation, type ValidationRule } from '@/composables/useFormValidation';

const form = useForm({
    nombre: '',
    email: '',
    telefono: '',
    direccion: '',
});

// Reglas de validación
const validationRules: Record<string, ValidationRule> = {
    nombre: {
        required: true,
        minLength: 2,
        maxLength: 100,
    },
    email: {
        required: true,
        email: true,
    },
    telefono: {
        phone: true,
        minLength: 10,
        maxLength: 20,
    },
    direccion: {
        maxLength: 255,
    },
};

const { errors, validate, validateFieldReal } = useFormValidation(form.data(), validationRules);

const submit = () => {
    if (!validate()) {
        return;
    }
    form.post('/clientes');
};
</script>

<template>
    <Head title="Crear Cliente" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Crear Cliente</h1>
                <Link href="/clientes">
                    <Button variant="outline">Volver</Button>
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <FormField
                    v-model="form.nombre"
                    type="text"
                    label="Nombre"
                    placeholder="Ej: Juan García"
                    required
                    :error="(errors as any).nombre"
                    @blur="validateFieldReal('nombre')"
                />

                <FormField
                    v-model="form.email"
                    type="email"
                    label="Email"
                    placeholder="Ej: juan@example.com"
                    required
                    :error="(errors as any).email"
                    @blur="validateFieldReal('email')"
                />

                <FormField
                    v-model="form.telefono"
                    type="tel"
                    label="Teléfono"
                    placeholder="Ej: +34 123 456 789"
                    :error="(errors as any).telefono"
                    @blur="validateFieldReal('telefono')"
                />

                <FormField
                    v-model="form.direccion"
                    type="text"
                    label="Dirección"
                    placeholder="Ej: Calle Principal 123"
                    :error="(errors as any).direccion"
                    @blur="validateFieldReal('direccion')"
                />

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing" class="cursor-pointer">
                        {{ form.processing ? 'Creando...' : 'Crear Cliente' }}
                    </Button>
                    <Link href="/clientes">
                        <Button type="button" variant="outline">Cancelar</Button>
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
