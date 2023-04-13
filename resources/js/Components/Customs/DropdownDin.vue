<script setup>
import Dropdown from 'primevue/dropdown';
defineProps({
    modelValue: String,
    label: String,
    sugerencia: String,
    error: String,
    filtrar: Boolean,
    datos: Array,
    opcionValue: String
});
defineEmits(['update:modelValue']);
</script>

<template>
    <div class="p-fluid p-input-filled border-0 space-y-2">
        <span>{{ label }}</span>
        <Dropdown  :option="1" :options="datos" :filter="filtrar" optionValue="name" optionLabel="name" :placeholder="sugerencia" :class="error != null ? 'p-invalid':''" @change="$emit('update:modelValue', $event.value)" />
        <small id="username2-help" class="p-error">{{
            error
        }}</small>
    </div>
</template>

