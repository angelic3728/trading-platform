<template>
    <img src="/icons/info.svg" class="tooltip-icon" data-toggle="tooltip" data-placement="top" :title="text" ref="tooltip">
</template>

<script>
    export default {

        props: ['text'],

        mounted(){

            $(this.$refs.tooltip).tooltip();

        }

    }
</script>
