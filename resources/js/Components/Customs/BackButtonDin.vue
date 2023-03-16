<script setup>
    import { usePage } from '@inertiajs/inertia-vue3';
	import { Inertia } from '@inertiajs/inertia';
    import Button from 'primevue/button';

	let urlPrev = usePage().props.value.urlPrev

        const back = () => {
            if (urlPrev !== 'empty') {
                Inertia.visit(urlPrev)
            }
        }
</script>
<template>

    <Button icon="pi pi-chevron-left" @click="back()" class=" p-button-warning p-button-sm" />

</template>
