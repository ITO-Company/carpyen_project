<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import FormField from '@/components/FormField.vue';
import FormTextarea from '@/components/FormTextarea.vue';
import { useFormValidation, type ValidationRule } from '@/composables/useFormValidation';

interface Props {
    categorias?: string[];
}

withDefaults(defineProps<Props>(), {
    categorias: () => [],
});

const form = useForm({
    nombre: '',
    descripcion: '',
    precio: '',
    cantidad: '',
    categoria: '',
});

const validationRules: Record<string, ValidationRule> = {
    nombre: {
        required: true,
        minLength: 2,
        maxLength: 150,
    },
    descripcion: {
        maxLength: 1000,
    },
    precio: {
        required: true,
        numeric: true,
    },
    cantidad: {
        numeric: true,
    },
    categoria: {
        maxLength: 100,
    },
};

const { errors, validate, validateFieldReal } = useFormValidation(form.data(), validationRules);

const submit = () => {
    if (!validate()) return;
    form.post('/productos');
};
</script>
<template>
    <Head title="Crear Producto" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Crear Producto</h1>
                <Link href="/productos"><Button variant="outline">Volver</Button></Link>
            </div>
            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <FormField
                    v-model="form.nombre"
                    type="text"
                    label="Nombre"
                    placeholder="Ej: Laptop Dell"
                    required
                    :error="(errors as any).nombre"
                    @blur="validateFieldReal('nombre')"
                />

                <FormTextarea
                    v-model="form.descripcion"
                    label="Descripción"
                    placeholder="Describe el producto"
                    :rows="4"
                    :error="(errors as any).descripcion"
                    @blur="validateFieldReal('descripcion')"
                />

                <FormField
                    v-model="form.precio"
                    type="number"
                    label="Precio"
                    placeholder="0.00"
                    required
                    step="0.01"
                    min="0"
                    :error="(errors as any).precio"
                    @blur="validateFieldReal('precio')"
                />

                <FormField
                    v-model="form.cantidad"
                    type="number"
                    label="Cantidad"
                    placeholder="0"
                    min="0"
                    :error="(errors as any).cantidad"
                    @blur="validateFieldReal('cantidad')"
                />

                <div>
                    <label class="block text-sm font-medium mb-2">Categoría</label>
                    <select
                        v-model="form.categoria"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white border-slate-300 dark:border-slate-700"
                    >
                        <option value="">Seleccionar categoría</option>
                        <option v-for="categoria in categorias" :key="categoria" :value="categoria">
                            {{ categoria }}
                        </option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Creando...' : 'Crear Producto' }}
                    </Button>
                    <Link href="/productos">
                        <Button type="button" variant="outline">Cancelar</Button>
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
