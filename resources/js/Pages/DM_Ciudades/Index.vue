<script setup>
import { ref, onMounted } from 'vue';
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTableDin from '@/Components/Customs/DataTableDin.vue';
import DropdownDepartamentoDin from '../../Components/Customs/DropdownDepartamentoDin.vue';
import axios from 'axios';


var ciudades = ref([])

const vm = {
    ID_departamento: 0
}

const columnas = [
{field:'ciudad', header:'Ciudad', typeFilter: 'text'},
{field: 'codigodane', header:'Codigo Dane', typeFilter: 'text'},
{field: 'activo', header:'Activo', dataType:"boolean"},
]
const filterColumnasGen = [
'ciudad',
'codigodane',
'activo'
]
const filtersInd =  {
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'ciudad': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
    'codigodane': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
}

const selectedDepartamento = (id) => {
        axios.get(route('getCiudades', id)).then((res) => {ciudades.value = res.data})
        vm.ID_departamento = id
}

const actualizarDatos = () => {
        axios.get(route('getCiudades', vm.ID_departamento)).then((res) => {ciudades.value = res.data})
}

const props = defineProps({
    paisID: Number,
    departamentoID: Number,
})

onMounted (() => {
    if(props.departamentoID > 0)
        vm.ID_departamento = props.departamentoID
    axios.get(route('getCiudades', vm.ID_departamento)).then(res =>( ciudades.value = res.data));

})

</script>

<template>
    <AppLayout title="Ciudades">
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
                        <span class="text-900 line-height-3">Ciudades</span>
                    </li>
                </ul>
                <div class="flex justify-content-between lg:flex-row">
                    <div>
                        <div class="font-medium text-3xl text-900">Ciudades</div>
                    </div>
                </div>
            </div>
            <div class="mx-4 flex justify mx-auto rounded-md p-2 bg-blue-700 text-white space-x-2 border-b-2 mb-8 w-full ">
                <DropdownDepartamentoDin  @selected-departamento=selectedDepartamento  :_paisID="props.paisID" :_departamentoID="props.departamentoID"/>
            </div>
        </div>

        <!-- <div>{{ count  }}</div> -->

        <!-- <div>{{ $store.state.count }}</div> -->
        <DataTableDin :model="ciudades" :columnas="columnas" :filterColumnasGen="filterColumnasGen" :filtersInd="filtersInd" modelName="ciudades" deleteName="ciudad" @actualizar-datos=actualizarDatos   >
        </DataTableDin>
    </AppLayout>
</template>
