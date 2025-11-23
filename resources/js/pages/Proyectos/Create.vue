<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import FormField from '@/components/FormField.vue';
import FormTextarea from '@/components/FormTextarea.vue';
import { useFormValidation, type ValidationRule } from '@/composables/useFormValidation';

interface Props {
    clientes: any[];
}

defineProps<Props>();

const form = useForm({
    nombre: '',
    descripcion: '',
    ubicacion: '',
    estado: 'Pendiente',
    id_cliente: '',
});

// Reglas de validación
const validationRules: Record<string, ValidationRule> = {
    nombre: {
        required: true,
        minLength: 3,
        maxLength: 150,
    },
    descripcion: {
        maxLength: 1000,
    },
    ubicacion: {
        maxLength: 200,
    },
    estado: {
        required: true,
    },
    id_cliente: {
        maxLength: 50,
    },
};

const { errors, validate, validateFieldReal } = useFormValidation(form.data(), validationRules);

const submit = () => {
    if (!validate()) {
        return;
    }
    form.post('/proyectos');
};
</script>

<template>
    <Head title="Crear Proyecto" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Crear Proyecto</h1>
                <Link href="/proyectos">
                    <Button variant="outline">Volver</Button>
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <FormField
                    v-model="form.nombre"
                    type="text"
                    label="Nombre"
                    placeholder="Ej: Proyecto Nueva Oficina"
                    required
                    :error="(errors as any).nombre"
                    @blur="validateFieldReal('nombre')"
                />

                <FormTextarea
                    v-model="form.descripcion"
                    label="Descripción"
                    placeholder="Describe el proyecto en detalle"
                    :rows="4"
                    :error="(errors as any).descripcion"
                    @blur="validateFieldReal('descripcion')"
                />

                <FormField
                    v-model="form.ubicacion"
                    type="text"
                    label="Ubicación"
                    placeholder="Ej: Calle Principal 123, Piso 2"
                    :error="(errors as any).ubicacion"
                    @blur="validateFieldReal('ubicacion')"
                />

                <div>
                    <label class="block text-sm font-medium mb-2">Cliente</label>
                    <select
                        v-model="form.id_cliente"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white border-slate-300 dark:border-slate-700"
                    >
                        <option value="">Seleccionar cliente</option>
                        <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                            {{ cliente.nombre }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Estado</label>
                    <select
                        v-model="form.estado"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white border-slate-300 dark:border-slate-700"
                    >
                        <option value="Pendiente">Pendiente</option>
                        <option value="En Progreso">En Progreso</option>
                        <option value="Completado">Completado</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Creando...' : 'Crear Proyecto' }}
                    </Button>
                    <Link href="/proyectos">
                        <Button type="button" variant="outline">Cancelar</Button>
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
