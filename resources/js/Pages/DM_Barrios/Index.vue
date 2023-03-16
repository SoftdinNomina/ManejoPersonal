<script setup>
import { ref, onMounted } from 'vue';
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTableDin from '@/Components/Customs/DataTableDin.vue';
import DropdownCiudadDin from '../../Components/Customs/DropdownCiudadDin.vue';
import axios from 'axios';


var barrios = ref([])

const vm = {
    ID_ciudad: 0
}

const columnas = [
{field:'barrio', header:'Barrio', typeFilter: 'text'},
{field: 'activo', header:'Activo', dataType:"boolean"},
]
const filterColumnasGen = ['barrio',
'activo'
]
const filtersInd =  {
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'barrio': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
}

const selectedCiudad = (id) => {
        axios.get(route('getBarrios', id)).then((res) => {barrios.value = res.data})
        vm.ID_ciudad = id
}

const actualizarDatos = () => {
        axios.get(route('getBarrios', vm.ID_ciudad)).then((res) => {barrios.value = res.data})
}

const props = defineProps({
    paisID: Number,
    departamentoID: Number,
    ciudadID: Number,
})

onMounted (() => {
    if(props.ciudadID > 0)
        vm.ID_ciudad = props.ciudadID
    axios.get(route('getBarrios', vm.ID_ciudad)).then(res =>( barrios.value = res.data));
})

</script>

<template>
    <AppLayout title="Barrios">
        <div class=" px-4 py-5 md:px-6 lg:px-8 block md:flex justify-between">
            <div>
                <ul class="list-none p-0 m-0 flex align-items-center font-medium mb-3">
                    <li>
                        <a class="text-500 no-underline line-height-3 cursor-pointer">Inicio</a>
                    </li>
                    <li class="px-2">
                        <i class="pi pi-angle-right text-500 line-height-3"></i>
                    </li>
                    <li>
                        <span class="text-900 line-height-3">Barrios</span>
                    </li>
                </ul>
                <div class="flex justify-content-between lg:flex-row">
                    <div>
                        <div class="font-medium text-3xl text-900">Barrios</div>
                    </div>
                </div>
            </div>
            <div class="mx-4 flex justify mx-auto rounded-md p-2 bg-blue-700 text-white space-x-2 border-b-2 mb-8 w-full ">
                <DropdownCiudadDin  @selected-ciudad="selectedCiudad" :_paisID="props.paisID" :_departamentoID="props.departamentoID" :_ciudadID="props.ciudadID"/>
            </div>
        </div>

        <DataTableDin :model="barrios" :columnas="columnas" :filterColumnasGen="filterColumnasGen" :filtersInd="filtersInd" modelName="barrios" deleteName="barrio" @actualizar-datos=actualizarDatos >
        </DataTableDin>
    </AppLayout>
</template>

