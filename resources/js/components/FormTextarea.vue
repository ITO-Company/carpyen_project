<script setup lang="ts">
import { computed } from 'vue';

interface Props {
  modelValue?: string;
  placeholder?: string;
  label?: string;
  error?: string | null;
  required?: boolean;
  disabled?: boolean;
  readonly?: boolean;
  rows?: number;
  minlength?: number;
  maxlength?: number;
  showCharCount?: boolean;
}

interface Emits {
  (e: 'update:modelValue', value: string): void;
  (e: 'blur'): void;
  (e: 'focus'): void;
}

const props = withDefaults(defineProps<Props>(), {
  placeholder: '',
  label: '',
  error: null,
  required: false,
  disabled: false,
  readonly: false,
  rows: 4,
  showCharCount: false,
});

const emit = defineEmits<Emits>();

const textareaId = computed(() => `textarea-${Math.random().toString(36).substr(2, 9)}`);

const charCount = computed(() => {
  if (!props.modelValue) return 0;
  return props.modelValue.length;
});

const textareaClass = computed(() => [
  'w-full px-4 py-2 border rounded-lg transition-colors resize-vertical',
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
      <label :for="textareaId" class="block text-sm font-medium">
        {{ label }}
        <span v-if="required" class="text-red-500">*</span>
      </label>
      <span v-if="showCharCount && maxlength" class="text-xs text-slate-500">
        {{ charCount }} / {{ maxlength }}
      </span>
    </div>

    <textarea
      :id="textareaId"
      :value="modelValue"
      :placeholder="placeholder"
      :disabled="disabled"
      :readonly="readonly"
      :required="required"
      :rows="rows"
      :minlength="minlength"
      :maxlength="maxlength"
      :class="textareaClass"
      @input="emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)"
      @blur="emit('blur')"
      @focus="emit('focus')"
    />

    <div v-if="error" class="flex items-start gap-2 text-sm text-red-500">
      <span class="text-lg leading-none">⚠</span>
      <span>{{ error }}</span>
    </div>
  </div>
</template>
