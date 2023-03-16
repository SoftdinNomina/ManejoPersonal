<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useConfirm } from "primevue/useconfirm";
import ConfirmPopup from "primevue/confirmpopup";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import TriStateCheckbox from 'primevue/tristatecheckbox';
import { useToast } from "primevue/usetoast";
import Toast from 'primevue/toast';

const props = defineProps({
    model: Array,
    columnas: Array,
    filterColumnasGen:Array,
    filtersInd: Object,
    modelName: String,
    deleteName: String,
})

const toast = useToast();
const confirm = useConfirm();
const emit = defineEmits(['actualizarDatos']);

const registrar = () => {
  Inertia.get(route(props.modelName+'.create'))
}
const editar = (id) => {
  Inertia.get(route(props.modelName+'.edit', id))
}

const deleted = (event, id) => {
    confirm.require({
    target: event.currentTarget,
    message: "¿Desea eliminar la fila "+ props.deleteName +" ? ",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
        Inertia.delete(route(props.modelName+'.destroy', id), {
            onSuccess: () => {
                toast.add({severity:'success', summary: 'Success Message', detail: props.deleteName.toUpperCase() +' Eliminado(a) ' , life: 3000});
                emit('actualizarDatos')
            },
            onError: (errors) => {
                toast.add({severity:'error', summary: 'Eliminar '+props.deleteName, detail:errors.delete, life: 3000});
            }
        })
    },
  });
};

var filtersInd = ref(props.filtersInd);

</script>

<template>
    <div>
        <Toast />

        <DataTable :value="props.model" :paginator="true" :rows="10"
        paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
        :rowsPerPageOptions="[5,10,20,50]"
        currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
        :globalFilterFields="filterColumnasGen"
        v-model:filters="filtersInd"
        filterDisplay="menu"
        >
        <template #header>
            <div class="flex justify-between space-x-10">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="filtersInd['global'].value" placeholder="Keyword Search" />
                </span>
                <div>
                    <Button icon="pi pi-plus" class="p-button-rounded p-button-primary "  iconPos="right" v-on:click="registrar()"/>
                </div>
            </div>
        </template>
            <Column v-for="col of props.columnas" :field="col.field" :dataType="col.dataType" :header="col.header" :key="col.field" >
                <template #body="{data}">
                    <i class="pi" :class="{'true-icon pi-check-circle text-green-500': data.activo, 'false-icon pi-times-circle text-red-500': !data.activo}"  v-show="col.field == 'activo'"></i>
                    <span v-if="col.field != 'activo'"> {{data[col.field]}}</span>
                </template>
                <template #filter="{filterModel}" v-if="col.typeFilter !== undefined ">
                    <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name" v-if="col.typeFilter == 'text'"/>
                    <TriStateCheckbox v-model="filterModel.value" v-if="col.typeFilter == 'check'" />
                </template>
            </Column>
            <Column field="id" header="Acciones">
                <template #body="{data}" >
                    <div class="space-x-2">
                        <Button icon="pi pi-pencil" class="p-button-rounded p-button-success"   v-on:click="editar(data.id)" />
                        <ConfirmPopup></ConfirmPopup>
                        <Button icon="pi pi-trash" class="p-button-rounded p-button-danger " @click="deleted($event, data.id)"/>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
