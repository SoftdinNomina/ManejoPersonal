<script setup>
import Dropdown from 'primevue/dropdown';
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useForm } from '@inertiajs/inertia-vue3';

const emit = defineEmits(['selectedCiudad']);
const paises = ref([])
const departamentos = ref([])
const ciudades = ref([])

const props = defineProps({
    _paisID: Number,
    _departamentoID: Number,
    _ciudadID: Number,
})

const form = useForm({
    paisID: props._paisID != null ? parseInt(props._paisID) : 0,
    departamentoID: props._departamentoID != null ? parseInt(props._departamentoID) : 0,
    ciudadID: props._ciudadID != null ? parseInt(props._ciudadID) : 0
})

onMounted (() => {
    axios.get(route('getPaises')).then((res) => {
        paises.value = res.data
    })
    selectedPais();
    selectedDepartamento();
})

const selectedPais = (event) => {
    axios.get(route('getDepartamentos', form.paisID)).then((res) => {
        departamentos.value = res.data
    })
}

const selectedDepartamento = (event) => {
    axios.get(route('getCiudades', form.departamentoID)).then((res) => {
        ciudades.value = res.data
    })
}

const selectedCiudad = (event) => {
    emit('selectedCiudad', form.ciudadID, form.departamentoID, form.paisID)
}

</script>
<template>
<div class="grid grid-cols-1 md:grid-cols-3 p-fluid p-input-filled  gap-4">
    <div class="p-fluid p-input-filled border-0 space-y-2">
        <span>Pais*</span>
        <Dropdown   :options="paises" @change="selectedPais(value)" v-model="form.paisID" optionValue="id"  optionLabel="pais" :filter="true"  placeholder="Seleccionar el Pais" :class="error != null ? 'p-invalid':''" ></Dropdown>
        <small id="username2-help" class="p-error">{{
            error
        }}</small>
    </div>

    <div class="p-fluid p-input-filled border-0 space-y-2">
        <span>Departamento*</span>
        <Dropdown :options="departamentos" @change="selectedDepartamento(value)" v-model="form.departamentoID" :filter="true"  optionValue="id"  optionLabel="departamento"  placeholder="Seleccionar el Departamento" :class="error != null ? 'p-invalid':''" ></Dropdown>
        <small id="username2-help" class="p-error">{{
            error
        }}</small>
    </div>

    <div class="p-fluid p-input-filled border-0 space-y-2">
        <span>Ciudad*</span>
        <Dropdown :options="ciudades" @change="selectedCiudad(value)" v-model="form.ciudadID" value="modelValue" :filter="true"  optionValue="id"  optionLabel="ciudad"  placeholder="Seleccionar la Ciudad" :class="error != null ? 'p-invalid':''" ></Dropdown>
        <small id="username2-help" class="p-error">{{
            error
        }}</small>
    </div>
</div>

</template>
