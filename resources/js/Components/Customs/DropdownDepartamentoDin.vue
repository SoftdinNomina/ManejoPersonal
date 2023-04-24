<script setup>
import Dropdown from 'primevue/dropdown';
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useForm } from '@inertiajs/inertia-vue3';

const emit = defineEmits(['selectedDepartamento']);
const paises = ref([])
const departamentos = ref([])

const props = defineProps({
    _paisID: Number,
    _departamentoID: Number,
})

const form = useForm({
    paisID: props._paisID != null ? parseInt(props._paisID) : 0,
    departamentoID: props._departamentoID != null ? parseInt(props._departamentoID) : 0,
})

onMounted (() => {
    axios.get(route('getPaises')).then((res) => {
        paises.value = res.data
    })
    selectedPais();
})

const selectedPais = (event) => {
    axios.get(route('getDepartamentos', form.paisID)).then((res) => {
        departamentos.value = res.data
    })
}

const selectedDepartamento = (event) => {
    emit('selectedDepartamento', form.departamentoID, form.paisID)
 }

</script>
<template>
<div class="grid grid-cols-1 md:grid-cols-2 p-fluid p-input-filled  gap-4">
    <div class="p-fluid p-input-filled border-0 space-y-2">
        <span>Pais*</span>
        <Dropdown  @change="selectedPais(value)" :options="paises" v-model="form.paisID" optionValue="id"  optionLabel="pais" :filter="true"  placeholder="Seleccionar el Pais" :class="error != null ? 'p-invalid':''" ></Dropdown>
        <small id="username2-help" class="p-error">{{
            error
        }}</small>
    </div>

    <div class="p-fluid p-input-filled border-0 space-y-2">
        <span>Departamento*</span>
        <Dropdown @change="selectedDepartamento(value)" :options="departamentos" v-model="form.departamentoID" optionValue="id"  optionLabel="departamento"  :filter="true"  placeholder="Seleccionar el Departamento" :class="error != null ? 'p-invalid':''" ></Dropdown>
        <small id="username2-help" class="p-error">{{
            error
        }}</small>
    </div>
</div>

</template>
