<template>
    <a href="#" class="btn-primary ml-2" @click.prevent="openModal">Upload</a>
</template>

<script>
export default {
    methods: {

        openModal(){

            this.$store.commit('modals/toggle', {
                modal: 'upload-document',
                show: true,
                data: {},
            });

        }

    }
}
</script>
