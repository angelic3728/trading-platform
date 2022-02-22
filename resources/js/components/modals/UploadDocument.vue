<template>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" :class="{'is-invalid': fields.title.error}" v-model="fields.title.value" placeholder="Enter the name of the document" required>

                        <span class="invalid-feedback" role="alert" v-if="fields.title.error">
                            <strong>{{ fields.title.error }}</strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea rows="3" class="form-control" :class="{'is-invalid': fields.description.error}" v-model="fields.description.value" placeholder="Enter an optional description"></textarea>

                        <span class="invalid-feedback" role="alert" v-if="fields.description.error">
                            <strong>{{ fields.description.error }}</strong>
                        </span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">File</label>
                        <input type="file" class="form-control" :class="{'is-invalid': fields.file.error}" placeholder="Select your file" ref="file" required>

                        <span class="invalid-feedback" role="alert" v-if="fields.file.error">
                            <strong>{{ fields.file.error }}</strong>
                        </span>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-rounded btn-animated" @click.prevent="upload">
                            <span v-if="!loading">Upload</span>
                            <div class="loader" v-if="loading"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return {
                loading: false,
                fields: {
                    title: {
                        value: '',
                        error: null,
                    },
                    description: {
                        value: '',
                        error: null,
                    },
                    file: {
                        error: null,
                    },
                }
            }
        },

        methods: {

            upload(){

                /**
                 * clear errors
                 */
                _.forEach(this.fields, (item) => {

                    item.error = null;

                });

                /**
                 * Start Loading
                 */
                this.loading = true;

                /**
                 * Prepare Form Data
                 */
                let data = new FormData();

                /**
                 * Add Image to Form data
                 */
                if(this.$refs.file.files[0]){

                    data.append('file', this.$refs.file.files[0]);

                }

                /**
                 * prepare form data
                 */
                data.append('title', this.fields.title.value);
                data.append('description', this.fields.description.value);

                /**
                 * Upload Data
                 */
                axios({
                    method: 'post',
                    url: '/api/documents',
                    data,
                })
                .then(response => {

                    /**
                     * Stop loading
                     */
                    this.loading = false;

                    /**
                     * Success message that reloads page
                     */
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Your document has been uploaded',
                        progressBar: true,
                        timeout: 2000,
                        callbacks: {
                            onClose: function() {

                                location.reload();

                            },
                        }
                    }).show();

                })
                .catch(error => {

                    /**
                     * Stop loading
                     */
                    this.loading = false;

                    if(error.response.status == 422){

                        /**
                         * Get Errors
                         */
                        let errors = _.get(error.response.data, 'errors', []);

                        /**
                         * Loop through errors and append them to the fields
                         */
                        _.forEach(errors, (value, key) => {

                            this.fields[key].error = value[0];

                        });

                    } else {

                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Something went wrong while uploading your documnet.',
                            progressBar: true,
                            timeout: 3000,
                        }).show();

                    }

                });

            }

        },

        computed: {

            show(){

                return this.$store.getters['modals/show']('upload-document');

            }

        },

        mounted(){

            /**
             * Listen to bootstrap modal events.
             */
            $(this.$refs.modal).on('hidden.bs.modal', () => {

                /**
                 * Update Vuex
                 */
                this.$store.commit('modals/toggle', {
                    modal: 'upload-document',
                    show: false,
                    data: {},
                });

                /**
                 * Reset data
                 */
                _.forEach(this.fields, (item) => {

                     item.error = null;

                     if(item.value){

                        item.value = ''

                     }

                });

                this.loading = false;

            });

        },

        watch: {

            show(value){

                if(value){

                    $(this.$refs.modal).modal('show');

                }

            }

        }

    }
</script>
