<script setup lang="ts">
import { computed } from 'vue';

interface Props {
  modelValue?: string | number;
  type?: string;
  placeholder?: string;
  label?: string;
  error?: string | null;
  required?: boolean;
  disabled?: boolean;
  readonly?: boolean;
  minlength?: number;
  maxlength?: number;
  step?: string;
  min?: string | number;
  max?: string | number;
  pattern?: string;
  autocomplete?: string;
  inputMode?: 'text' | 'decimal' | 'numeric' | 'tel' | 'search' | 'email' | 'url';
  showCharCount?: boolean;
}

interface Emits {
  (e: 'update:modelValue', value: string | number): void;
  (e: 'blur'): void;
  (e: 'focus'): void;
  (e: 'change'): void;
}

const props = withDefaults(defineProps<Props>(), {
  type: 'text',
  placeholder: '',
  label: '',
  error: null,
  required: false,
  disabled: false,
  readonly: false,
  showCharCount: false,
});

const emit = defineEmits<Emits>();

const inputId = computed(() => `input-${Math.random().toString(36).substr(2, 9)}`);

const charCount = computed(() => {
  if (!props.modelValue) return 0;
  return String(props.modelValue).length;
});

const inputClass = computed(() => [
  'w-full px-4 py-2 border rounded-lg transition-colors',
  'dark:bg-slate-900 dark:text-white dark:border-slate-700',
  'focus:outline-none focus:ring-2 focus:ring-offset-2',
  props.error
    ? 'border-red-500 focus:ring-red-500 focus:border-red-500'
    : 'border-slate-300 focus:ring-blue-500 focus:border-blue-500',
  props.disabled && 'opacity-50 cursor-not-allowed',
  props.readonly && 'bg-slate-50 dark:bg-slate-800 cursor-default',
]);
</script>

<template>
  <div class="space-y-2">
    <div v-if="label" class="flex items-center justify-between">
      <label :for="inputId" class="block text-sm font-medium">
        {{ label }}
        <span v-if="required" class="text-red-500">*</span>
      </label>
      <span v-if="showCharCount && maxlength" class="text-xs text-slate-500">
        {{ charCount }} / {{ maxlength }}
      </span>
    </div>

    <input
      :id="inputId"
      :value="modelValue"
      :type="type"
      :placeholder="placeholder"
      :disabled="disabled"
      :readonly="readonly"
      :required="required"
      :minlength="minlength"
      :maxlength="maxlength"
      :step="step"
      :min="min"
      :max="max"
      :pattern="pattern"
      :autocomplete="autocomplete"
      :inputmode="inputMode"
      :class="inputClass"
      @input="emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      @blur="emit('blur')"
      @focus="emit('focus')"
      @change="emit('change')"
    />

    <div v-if="error" class="flex items-start gap-2 text-sm text-red-500">
      <span class="text-lg leading-none">⚠</span>
      <span>{{ error }}</span>
    </div>
  </div>
</template>
