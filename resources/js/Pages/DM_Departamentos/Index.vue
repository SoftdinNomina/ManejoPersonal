<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import AppLayout from '@/Layouts/AppLayout.vue';
import Dropdown from 'primevue/dropdown';
import DataTableDin from '@/Components/Customs/DataTableDin.vue';

const props = defineProps({
    departamentos: Array,
    paises: Array,
    paisID: Number
})

const columnas = [
{field:'departamento', header:'Departamento', typeFilter: 'text'},
{field: 'codigodane', header:'Codigo Dane', typeFilter: 'text'},
{field: 'codigo_iso', header:'Codigo ISO', typeFilter: 'text'},
{field: 'activo', header:'Activo', dataType:"boolean"},
]
const filterColumnasGen = ['departamento',
'codigodane',
'codigo_iso',
'activo'
]
const filtersInd =  {
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'departamento': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
    'codigodane': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
    'codigo_iso': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
}

const form = useForm({
    paisID: parseInt(props.paisID),
})

const selectedPais = (event) => {
    form.get(route('departamentos.index'))
}

</script>

<template>
    <AppLayout title="Departamentos">
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
                        <span class="text-900 line-height-3">Departamentos</span>
                    </li>
                </ul>
                <div class="flex justify-content-between lg:flex-row">
                    <div>
                        <div class="font-medium text-3xl text-900">Departamentos</div>
                    </div>
                </div>
            </div>
            <div class="mx-4 block justify-start mx-auto rounded-md p-2 bg-blue-700 text-white border-b-2 mb-8 w-full " >
                <span>Paises*</span>
                <div>
                    <Dropdown :filter="true" v-model="form.paisID" @change="selectedPais(value)" :options="paises" optionLabel="pais" optionValue="id" placeholder="Seleccionar el Pais" />
                </div>
            </div>
        </div>
        <DataTableDin :model="departamentos" :columnas="columnas" :filterColumnasGen="filterColumnasGen" :filtersInd="filtersInd" modelName="departamentos" deleteName="departamento" >
        </DataTableDin>
    </AppLayout>
</template>
