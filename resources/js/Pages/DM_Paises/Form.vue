<script setup>
import { ref } from 'vue';
import { useForm } from "@inertiajs/inertia-vue3";
import Button from 'primevue/button';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputSwitch from 'primevue/inputswitch';
import InputTextDin from '@/Components/Customs/InputTextDin.vue';
import BackButtonDin from '@/Components/Customs/BackButtonDin.vue';
import Dialog from 'primevue/dialog';
import FileUpload from 'primevue/fileupload';
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import { exportExcel } from "@/Composable/ExportData";


const formArchivo = useForm({
    file: null,
    length: 0
})

const archivoErrores = ref([]);
const toast = useToast();
const visible = ref(false);
const totalSize = ref(0);
const totalSizePercent = ref(0);
const files = ref([]);
const visibleErrores = ref(false);
const { exporting } = exportExcel(archivoErrores.value, 'ArchivoErrores')


const onRemoveTemplatingFile = (file, removeFileCallback, index) => {
    removeFileCallback(index);
    totalSize.value -= parseInt(formatSize(file.size));
    totalSizePercent.value = totalSize.value / 10;
};

const onClearTemplatingUpload = (clear) => {
    clear();
    totalSize.value = 0;
    totalSizePercent.value = 0;
};

const onSelectedFiles = (event) => {
    files.value = event.files;
    files.value.forEach((file) => {
        totalSize.value += parseInt(formatSize(file.size));
    });
};


const uploadEvent = (callback) => {
        totalSizePercent.value = totalSize.value / 10;
        formArchivo.file = files.value[0];
        formArchivo.post(route('paises_import')
        , {
                onSuccess: () => {
                    toast.add({severity:'success', summary: 'Exito', detail: ' Importación Exitosa ' , life: 3000});
                },
                onError: (errors) => {
                    archivoErrores.value = JSON.parse(errors[0]);
                    formArchivo.length = archivoErrores.value[0]['filas'];
                    toast.add({severity:'error', summary: 'Error', detail:'Importación con Novedad o NO Exitosa', life: 3000});
                }
            }
            );
        callback();
};

const onTemplatedUpload = () => {
    toast.add({ severity: "info", summary: "Success", detail: "File Uploaded", life: 3000 });
};

const formatSize = (bytes) => {
    if (bytes === 0) return "0 B";
    const k = 1024;
    const sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

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
        <Toast />
        <div class="py-2">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                    <div class="p-6 border-b border-gray-200 ">
                        <div class="text-center mx-auto rounded-md p-2 bg-blue-700 text-white space-x-2 border-b-2 mb-8">
                            <BackButtonDin class="float-left"  />
                            <span class="text-2xl  mt-1 font-bold capitalize mx-2">{{ props.pais == null ? 'crear':'editar' }} Pais</span>
                            <Button v-if="props.pais == null"  icon="pi pi-upload" class=" p-button-primary  p-button-sm float-right"  title="Importar" @click="visible = true"/>
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
                                        <InputTextDin  v-model="form.pais" placeholder="Escriba el nombre del Pais" :class="error != null ? 'p-invalid':''" @input="$emit('update:modelValue', $event.target.value)"></InputTextDin>
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
        <Dialog v-model:visible="visible" modal header="Cargar Archivo"  :style="{ width: '50vw' }">
            <div class="card">
                <Toast />
                <FileUpload name="file"  @upload="onTemplatedUpload($event)" accept=".xls,.xlsx"  :multiple="false" :maxFileSize="10000000" @select="onSelectedFiles">
                    <template #header="{ chooseCallback, uploadCallback, clearCallback, files }">
                        <div class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2">
                            <div class="flex gap-2">
                                <Button @click="chooseCallback()" icon="pi pi-book" rounded outlined :disabled="!files && files.length > 0" title="Cargar archivo"></Button>
                                <Button @click="uploadEvent(uploadCallback)" icon="pi pi-cloud-upload" rounded outlined severity="success" :disabled="!files || files.length === 0" title="Subir archivo"></Button>
                                <Button @click="clearCallback()" icon="pi pi-times" rounded outlined severity="danger" :disabled="!files || files.length === 0" title="Cancelar archivo"></Button>
                            </div>
                            <ProgressBar :value="totalSizePercent" :showValue="false" :class="['md:w-20rem h-1rem w-full md:ml-auto', { 'exceeded-progress-bar': totalSizePercent > 100 }]">
                                <span class="white-space-nowrap">{{ totalSize }}B / 10Mb</span>
                            </ProgressBar>
                        </div>
                    </template>
                    <template #content="{ files, uploadedFiles, removeUploadedFileCallback, removeFileCallback }">
                        <div v-if="files.length > 0">
                            <h5>Pending</h5>
                            <div class="flex flex-wrap p-0 sm:p-5 gap-5">
                                <div v-for="(file, index) of files" :key="file.name + file.type + file.size" class="card m-0 px-6 flex flex-column border-1 surface-border align-items-center gap-3">
                                    <span class="font-semibold">{{ file.name }}</span>
                                    <div>{{ formatSize(file.size) }}</div>
                                    <Badge value="Pending" severity="warning" />
                                    <Button icon="pi pi-times" @click="onRemoveTemplatingFile(file, removeFileCallback, index)" outlined rounded  severity="danger" title="Eliminar archivo"/>
                                </div>
                            </div>
                        </div>

                        <div v-if="uploadedFiles.length > 0">
                            <h5>Completed</h5>
                            <div class="flex flex-wrap p-0 sm:p-5 gap-5">
                                <div v-for="(file, index) of uploadedFiles" :key="file.name + file.type + file.size" class="card m-0 px-6 flex flex-column border-1 surface-border align-items-center gap-3">
                                    <span class="font-semibold">{{ file.name }}</span>
                                    <div>{{ formatSize(file.size) }} </div>
                                    <Badge value="Completed" class="mt-3" severity="success" />
                                    <Button icon="pi pi-times" @click="removeUploadedFileCallback(index)" outlined rounded  severity="danger" title="Remover archivo"/>
                                    <Button v-if="archivoErrores.length === 0" icon='pi pi-thumbs-up' severity="success" rounded outlined   title="Importación del archivo exitosa"></Button>
                                    <Button v-else-if="archivoErrores.length === formArchivo.length" icon='pi pi-thumbs-down' severity="danger" @click="visibleErrores = true" rounded outlined   title="Errores de la importación del archivo"></Button>
                                    <Button v-else icon='pi pi-info' severity="warning"  @click="visibleErrores = true" rounded outlined   title="Errores de la importación del archivo"></Button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #empty>
                        <div center class="align-items-center justify-center text-center ">
                            <i class="pi pi-cloud-upload border-2 border-circle p-5 text-8xl text-400 border-400  rounded-full"  />
                            <p class="mt-4 mb-0 text-xs"> Arrastre y suelte los archivos aquí para cargarlos.</p>
                        </div>
                    </template>
                </FileUpload>
            </div>
        </Dialog>
        <Dialog v-model:visible="visibleErrores" modal header="Errores de la importación del archivo"  :style="{ width: '50vw' }">
            <div class="flex justify-between space-x-5">
                <!-- <Button icon="pi pi-download" class=" p-button-success  p-button-sm" title="Descargar" @click="exporting" /> -->
            </div>
            <div class="card">
                <div v-for="(archivoError, key ) of archivoErrores" v-bind:key="key" >
                    <div :style="{ backgroundColor:'aliceblue' }">
                        <a href="#" :style="{ color:'Hex' }" class="mb-1 p-4 no-underline flex ">
                            <strong>{{ key + 1}} {{  archivoError['mensaje'] }}</strong>
                        </a>
                    </div>
                    <div class="tab__content p-2"  v-html="archivoError['detalle']"></div>
                </div>
            </div>
        </Dialog>
    </AppLayout>
</template>
