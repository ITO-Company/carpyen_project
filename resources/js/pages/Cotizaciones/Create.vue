<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import FormField from '@/components/FormField.vue';
import FormTextarea from '@/components/FormTextarea.vue';
import { useFormValidation, type ValidationRule } from '@/composables/useFormValidation';

interface Props {
    proyectos: any[];
}

withDefaults(defineProps<Props>(), {
    proyectos: () => [],
});

const form = useForm({
    numero: '',
    descripcion: '',
    monto: '',
    fecha_vigencia: '',
    estado: 'Pendiente',
    tipo_metro: '',
    costo_metro: '',
    cantidad_metro: '',
    costo_muebles: '',
    numero_muebles: '',
    id_proyecto: '',
});

const validationRules: Record<string, ValidationRule> = {
    numero: {
        required: true,
        minLength: 3,
        maxLength: 50,
    },
    descripcion: {
        maxLength: 1000,
    },
    monto: {
        required: true,
        numeric: true,
    },
    fecha_vigencia: {
        required: true,
    },
    estado: {
        required: true,
    },
    tipo_metro: {
        maxLength: 100,
    },
    costo_metro: {
        numeric: true,
    },
    cantidad_metro: {
        numeric: true,
    },
    costo_muebles: {
        numeric: true,
    },
    numero_muebles: {
        numeric: true,
    },
};

const { errors, validate, validateFieldReal } = useFormValidation(form.data(), validationRules);

const submit = () => {
    if (!validate()) return;
    form.post('/cotizaciones');
};
</script>

<template>
    <Head title="Crear Cotización" />
    <AppLayout>
        <div class="p-6 max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Crear Cotización</h1>
                <Link href="/cotizaciones"><Button variant="outline">Volver</Button></Link>
            </div>
            <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-slate-800 p-6 rounded-lg border">
                <FormField
                    v-model="form.numero"
                    type="text"
                    label="Número Cotización"
                    placeholder="COT-001"
                    required
                    :error="(errors as any).numero"
                    @blur="validateFieldReal('numero')"
                />

                <FormTextarea
                    v-model="form.descripcion"
                    label="Descripción"
                    placeholder="Descripción de la cotización"
                    :rows="4"
                    :error="(errors as any).descripcion"
                    @blur="validateFieldReal('descripcion')"
                />

                <FormField
                    v-model="form.monto"
                    type="number"
                    label="Monto"
                    placeholder="0.00"
                    required
                    step="0.01"
                    min="0"
                    :error="(errors as any).monto"
                    @blur="validateFieldReal('monto')"
                />

                <FormField
                    v-model="form.fecha_vigencia"
                    type="date"
                    label="Fecha de Vigencia"
                    required
                    :error="(errors as any).fecha_vigencia"
                    @blur="validateFieldReal('fecha_vigencia')"
                />

                <div>
                    <label class="block text-sm font-medium mb-2">Proyecto</label>
                    <select
                        v-model="form.id_proyecto"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white border-slate-300 dark:border-slate-700"
                    >
                        <option value="">Seleccionar proyecto</option>
                        <option v-for="proyecto in proyectos" :key="proyecto.id" :value="proyecto.id">
                            {{ proyecto.nombre }}
                        </option>
                    </select>
                </div>

                <FormField
                    v-model="form.tipo_metro"
                    type="text"
                    label="Tipo Metro"
                    placeholder="Tipo de material"
                    :error="(errors as any).tipo_metro"
                    @blur="validateFieldReal('tipo_metro')"
                />

                <div class="grid grid-cols-2 gap-4">
                    <FormField
                        v-model="form.costo_metro"
                        type="number"
                        label="Costo Metro"
                        placeholder="0.00"
                        step="0.01"
                        min="0"
                        :error="(errors as any).costo_metro"
                        @blur="validateFieldReal('costo_metro')"
                    />
                    <FormField
                        v-model="form.cantidad_metro"
                        type="number"
                        label="Cantidad Metro"
                        placeholder="0.00"
                        step="0.01"
                        min="0"
                        :error="(errors as any).cantidad_metro"
                        @blur="validateFieldReal('cantidad_metro')"
                    />
                </div>

                <FormField
                    v-model="form.costo_muebles"
                    type="number"
                    label="Costo Muebles"
                    placeholder="0.00"
                    step="0.01"
                    min="0"
                    :error="(errors as any).costo_muebles"
                    @blur="validateFieldReal('costo_muebles')"
                />

                <FormField
                    v-model="form.numero_muebles"
                    type="number"
                    label="Número de Muebles"
                    placeholder="0"
                    min="0"
                    :error="(errors as any).numero_muebles"
                    @blur="validateFieldReal('numero_muebles')"
                />

                <div>
                    <label class="block text-sm font-medium mb-2">Estado</label>
                    <select
                        v-model="form.estado"
                        class="w-full px-4 py-2 border rounded-lg dark:bg-slate-900 dark:text-white border-slate-300 dark:border-slate-700"
                    >
                        <option value="Pendiente">Pendiente</option>
                        <option value="Aprobado">Aprobado</option>
                        <option value="Rechazado">Rechazado</option>
                        <option value="Expirado">Expirado</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Creando...' : 'Crear Cotización' }}
                    </Button>
                    <Link href="/cotizaciones">
                        <Button type="button" variant="outline">Cancelar</Button>
                    </Link>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
