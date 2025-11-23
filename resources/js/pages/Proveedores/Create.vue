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
    persona_contacto: '',
    ruc: '',
});

const validationRules: Record<string, ValidationRule> = {
    nombre: {
        required: true,
        minLength: 2,
        maxLength: 150,
    },
    email: {
        email: true,
    },
    telefono: {
        phone: true,
    },
    direccion: {
        maxLength: 255,
    },
    persona_contacto: {
        minLength: 2,
        maxLength: 100,
    },
    ruc: {
        maxLength: 50,
    },
};

const { errors, validate, validateFieldReal } = useFormValidation(form.data(), validationRules);

const submit = () => {
    if (!validate()) return;
    form.post('/proveedores');
};
</script>
<template>
    <Head title="Crear Proveedor" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Crear Proveedor</h1>
                <Link href="/proveedores"><Button variant="outline">Volver</Button></Link>
            </div>
            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <FormField
                    v-model="form.nombre"
                    type="text"
                    label="Nombre Empresa"
                    placeholder="Ej: Distribuidora XYZ"
                    required
                    :error="(errors as any).nombre"
                    @blur="validateFieldReal('nombre')"
                />

                <FormField
                    v-model="form.email"
                    type="email"
                    label="Email"
                    placeholder="contacto@empresa.com"
                    :error="(errors as any).email"
                    @blur="validateFieldReal('email')"
                />

                <FormField
                    v-model="form.telefono"
                    type="tel"
                    label="Teléfono"
                    placeholder="+34 123 456 789"
                    :error="(errors as any).telefono"
                    @blur="validateFieldReal('telefono')"
                />

                <FormField
                    v-model="form.direccion"
                    type="text"
                    label="Dirección"
                    placeholder="Calle Principal 123"
                    :error="(errors as any).direccion"
                    @blur="validateFieldReal('direccion')"
                />

                <FormField
                    v-model="form.persona_contacto"
                    type="text"
                    label="Persona de Contacto"
                    placeholder="Nombre del contacto"
                    :error="(errors as any).persona_contacto"
                    @blur="validateFieldReal('persona_contacto')"
                />

                <FormField
                    v-model="form.ruc"
                    type="text"
                    label="RUC"
                    placeholder="Número de RUC"
                    :error="(errors as any).ruc"
                    @blur="validateFieldReal('ruc')"
                />

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Creando...' : 'Crear Proveedor' }}
                    </Button>
                    <Link href="/proveedores">
                        <Button type="button" variant="outline">Cancelar</Button>
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
