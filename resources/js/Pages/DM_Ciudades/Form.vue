<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import Button from 'primevue/button';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputSwitch from 'primevue/inputswitch';
import InputTextDin from '@/Components/Customs/InputTextDin.vue';
import BackButtonDin from '@/Components/Customs/BackButtonDin.vue';

const props = defineProps({
    ciudad: Object,
    paisNombre: String,
    paisID: Number,
    departamentoNombre: String,
    departamentoID: Number,
});

const form = useForm({
    id: props.ciudad != null ? props.ciudad.id : '0',
    departamento_id: props.ciudad != null ? props.ciudad.departamento_id : props.departamentoID,
    ciudad: props.ciudad != null ? props.ciudad.ciudad : '',
    codigodane: props.ciudad != null ? props.ciudad.codigodane : '',
    activo: props.ciudad != null ? (props.ciudad.activo ? true : false) : true,
});

const submit = (id) => {
    if (props.ciudad != null) {
        return form.put(route("ciudades.update", id))
    }
    form.post(route("ciudades.store"));
};

</script>

<template>
    <AppLayout title="Ciudades">
        <div class="py-2">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                    <div class="p-6 border-b border-gray-200 ">
                        <div class="flex justify-between mx-auto rounded-md p-2 bg-blue-700 text-white space-x-2 border-b-2 mb-8">
                            <BackButtonDin />
                            <span class="text-2xl  mt-1 font-bold capitalize mx-2">{{ props.ciudad == null ? 'crear':'editar' }} Ciudad</span>
                            <Button icon="pi pi-upload" class=" p-button-primary  p-button-sm"  title="Importar" />
                        </div>
                        <form @submit.prevent="submit(form.id)">
                            <div class="w-full grid grid-cols-1 md:grid-cols-4 gap-2 space-y-4">
                                <div class="col-span-1 md:col-span-4 p-fluid p-input-filled ">
                                    <div class="grid grid-cols-1 md:grid-cols-2 p-fluid p-input-filled  gap-4">
                                        <div class="p-fluid p-input-filled border-0 space-y-2">
                                            <div class="flex justify-between">
                                                <span>Pais*</span>
                                            </div>
                                            <InputTextDin  v-model="props.paisNombre" placeholder=""   :class="error != null ? 'p-invalid':''" @input="$emit('update:modelValue', $event.target.value)" readonly="true"></InputTextDin>
                                        </div>
                                        <div class="p-fluid p-input-filled border-0 space-y-2">
                                            <div class="p-fluid p-input-filled border-0 space-y-2">
                                                <span>Departamento*</span>
                                            </div>
                                            <InputTextDin  v-model="props.departamentoNombre" placeholder=""   :class="error != null ? 'p-invalid':''" @input="$emit('update:modelValue', $event.target.value)" readonly="true"></InputTextDin>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-1 pt-4 rounded-t-xl md:col-span-4 p-fluid p-input-filled border-t-2">
                                    <!-- Colocar una liena aqui -->
                                    <div class="col-span-1 md:col-span-4 p-fluid p-input-filled ">
                                        <div class="p-fluid p-input-filled border-0 space-y-2">
                                            <div class="flex justify-between">
                                                <span>Ciudad*</span>
                                                <div>
                                                    <InputSwitch v-model="form.activo" />
                                                </div>
                                            </div>
                                            <InputTextDin  v-model="form.ciudad" placeholder="Escriba el nombre de la Ciudad" :class="error != null ? 'p-invalid':''" @input="$emit('update:modelValue', $event.target.value)"></InputTextDin>
                                            <small id="username2-help" class="p-error">{{
                                                form.errors.ciudad
                                            }}</small>
                                        </div>
                                    </div>
                                </div>
                                <InputTextDin v-model="form.codigodane" label="Codigo DANE" :error="form.errors.codigodane" sugerencia="Escriba el codigo dane"></InputTextDin>
                            </div>

                            <div class="mt-6 w-full flex justify-end">
                                <button type="submit"
                                    class="text-2xl font-bold text-white bg-blue-700  focus:outline-none  font-medium rounded-lg  px-5 py-2.5 "
                                    :disabled="form.processing" :class="{ 'opacity-25': form.processing }">
                                    {{ props.departamento != null ? 'Actualizar' : 'Enviar' }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>
