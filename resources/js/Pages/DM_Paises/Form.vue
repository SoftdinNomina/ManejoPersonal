<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import Button from 'primevue/button';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputSwitch from 'primevue/inputswitch';
import Dropdown from 'primevue/dropdown';
import InputTextDin from '@/Components/Customs/InputTextDin.vue';
import InputText from "primevue/inputtext";
import BackButtonDin from '@/Components/Customs/BackButtonDin.vue';

const props = defineProps({
    pais: Object,
});

const continentes = [
    { name: 'África' },
    { name: 'América' },
    { name: 'Antártida' },
    { name: 'Asia' },
    { name: 'Europa' },
    { name: 'Oceanía' }
]

// const selectedContinente = ref(null);

// var checked = ref(true);

const form = useForm({
    id: props.pais != null ? props.pais.id : '0',
    pais: props.pais != null ? props.pais.pais : '',
    codigo_alfa2: props.pais != null ? props.pais.codigo_alfa2 : '',
    codigo_alfa3: props.pais != null ? props.pais.codigo_alfa3 : '',
    codigo_numerico: props.pais != null ? props.pais.codigo_numerico : '',
    continente: props.pais != null ? props.pais.continente : '',
    activo: props.pais != null ? (props.pais.activo ? true : false) : true,
});

const submit = (id) => {
    if (props.pais != null) {
        return form.put(route("paises.update", id))
    }
    form.post(route("paises.store"));
};
</script>

<template>
    <AppLayout title="Paises">
        <div class="py-2">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                    <div class="p-6 border-b border-gray-200 ">
                        <div class="flex justify-between mx-auto rounded-md p-2 bg-blue-700 text-white space-x-2 border-b-2 mb-8">
                            <BackButtonDin />
                            <span class="text-2xl  mt-1 font-bold capitalize mx-2">{{ props.pais == null ? 'crear':'editar' }} Pais</span>
                            <Button icon="pi pi-upload" class=" p-button-success  p-button-sm"  label="Cargar"/>

                        </div>
                        <form @submit.prevent="submit(form.id)">
                            <div class="w-full grid grid-cols-1 md:grid-cols-4 gap-2 space-y-4">
                                <div class="col-span-1 md:col-span-4 p-fluid p-input-filled ">

                                    <div class="p-fluid p-input-filled border-0 space-y-2">
                                        <div class="flex justify-between">
                                            <span>Pais*</span>
                                            <div>
                                                <InputSwitch v-model="form.activo" />
                                            </div>
                                        </div>
                                        <InputText  v-model="form.pais" placeholder="Escriba el nombre del Pais" :class="error != null ? 'p-invalid':''" @input="$emit('update:modelValue', $event.target.value)"></InputText>
                                        <small id="username2-help" class="p-error">{{
                                            form.errors.pais
                                        }}</small>
                                    </div>
                                </div>
                                <InputTextDin v-model="form.codigo_alfa2" label="Codigo Alfa 2" :error="form.errors.codigo_alfa2" sugerencia="Escriba el codigo alfa 2"></InputTextDin>
                                <InputTextDin v-model="form.codigo_alfa3" label="Codigo Alfa 3" :error="form.errors.codigo_alfa3" sugerencia="Escriba el codigo alfa 3"></InputTextDin>
                                <InputTextDin v-model="form.codigo_numerico" label="Codigo Numerico" :error="form.errors.codigo_numerico" sugerencia="Escriba el codigo numerico"></InputTextDin>
                                <div class="p-fluid p-input-filled border-0 space-y-2">
                                    <span>Continente*</span>
                                    <div>
                                        <Dropdown v-model="form.continente" optionLabel="name" optionValue="name"
                                            :options="continentes" placeholder="Seleccionar Continente" :class="error != null ? 'p-invalid':''"/>
                                            <small id="username2-help" class="p-error">{{
                                                form.errors.continente
                                             }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 w-full flex justify-end">
                                  <button type="submit"
                                class="text-2xl font-bold text-white bg-blue-700  focus:outline-none  font-medium rounded-lg  px-5 py-2.5 "
                                :disabled="form.processing" :class="{ 'opacity-25': form.processing }">
                                {{ props.pais != null ? 'Actualizar' : 'Enviar' }}
                            </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>
