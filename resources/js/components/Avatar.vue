<template>
    <form :action="action" method="post" enctype="multipart/form-data" class="settings-avatar" ref="form">
        <input name="_token" v-model="csrf_token" hidden>
        <input name="_method" value="PUT" hidden>

        <div class="avatar-holder" @click="selectFile">
            <img :src="src" class="avatar" />
            <div class="avatar-hover">
                <img src="/icons/settings/file-upload.svg" />
            </div>
        </div>
        <a href="#" @click.prevent="selectFile">Change Avatar</a>
        <input ref="avatar" name="avatar" type="file" style="display: none;" @change="uploadAvatar" />
    </form>
</template>

<script>
    export default {

        props: ['src', 'action'],

        data(){
            return {
                csrf_token: null,
            }
        },

        mounted(){

            this.csrf_token = $('meta[name="csrf-token"]').attr('content');

        },

        methods: {

            selectFile(){

                /**
                 * Open file system
                 */
                this.$refs.avatar.click();

            },

            uploadAvatar(){

                this.$refs.form.submit();

            }

        }

    }
</script>
