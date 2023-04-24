<script setup>
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import AppLayout from '@/Layouts/AppLayout.vue';
import DataTableDin from '@/Components/Customs/DataTableDin.vue';

defineProps({
    paises: Array,
})

const columnas = [{field: 'id', header:'ID'},
{field:'pais', header:'Pais', typeFilter: 'text'},
{field: 'codigo_alfa2', header:'Codigo Alfa2', typeFilter: 'text'},
{field: 'codigo_alfa3', header:'Codigo Alfa3', typeFilter: 'text'},
{field: 'codigo_numerico', header:'Codigo Numerico', typeFilter: 'text'},
{field: 'continente', header:'Continente', typeFilter: 'text'},
{field: 'activo', header:'Activo', dataType:"boolean"},
]

const filterColumnasGen = ['pais',
'codigo_alfa2',
'codigo_alfa3',
'codigo_numerico',
'continente',
'activo'
]

const filtersInd =  {
    'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    'pais': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
    'codigo_alfa2': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
    'codigo_alfa3': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
    'codigo_numerico': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
    'continente': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]}
    // 'activo':  {value: null, matchMode: FilterMatchMode.EQUALS}
}

</script>

<template>
    <AppLayout title="Paises">
        <div class="surface-section px-4 py-5 md:px-6 lg:px-8">
            <ul class="list-none p-0 m-0 flex align-items-center font-medium mb-3">
                <li>
                    <a class="text-500 no-underline line-height-3 cursor-pointer">Inicio</a>
                </li>
                <li class="px-2">
                    <i class="pi pi-angle-right text-500 line-height-3"></i>
                </li>
                <li>
                    <span class="text-900 line-height-3">Paises</span>
                </li>
            </ul>
            <div class="flex align-items-start flex-column lg:justify-content-between lg:flex-row">
                <div>
                    <div class="font-medium text-3xl text-900">Paises</div>

                </div>
                <div class="mt-3 lg:mt-0">
                    <Button label="Add" class="p-button-outlined mr-2" icon="pi pi-user-plus"></Button>

                </div>
            </div>
        </div>
        <DataTableDin :model="paises" :columnas="columnas" :canAdd="true" :filterColumnasGen="filterColumnasGen" :filtersInd="filtersInd" modelName="paises" deleteName="pais" >

        </DataTableDin>
    </AppLayout>
</template>
