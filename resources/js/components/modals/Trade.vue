<template>
    <div class="modal fade buy-sell-shares" ref="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="action == 'buy'">Buy Shares from {{ symbol }}</h5>
                    <h5 class="modal-title" v-if="action == 'sell'">Sell {{ symbol }} Shares</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body completed" v-if="showTradeCompleted">
                    <h3>Congratulations</h3>
                    <p v-if="action == 'buy'">
                        Your trade has been confimed at the institutional price. <br>
                        We have sent you an email with the trade details. <br> <br>

                        Thank you for trading with Hoover Hyfield
                    </p>
                    <p v-if="action == 'sell'">
                        Your trade has been confimed at the retail price. <br>
                        We have sent you an email with the trade details. <br> <br>

                        Thank you for trading with Hoover Hyfield
                    </p>
                </div>
                <div class="modal-body loading" v-if="showStockDetailsLoader">
                    <div class="loader"></div>
                    <small>Loading information about this stock</small>
                </div>
                <div class="modal-body" v-if="showStockDetails">
                    <h5 v-if="action == 'buy'">Below you will find the most recent information about the stock you would like to buy shares from</h5>
                    <h5 v-if="action == 'sell'">Below you will find the most recent information about the stock you would like to sell shares from</h5>

                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Symbol</strong>:
                                </td>
                                <td>{{ symbol }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Company</strong>:
                                </td>
                                <td>{{ stock.company_name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Retail Price</strong>:
                                </td>
                                <td>{{ price }}</td>
                            </tr>
                            <tr v-if="action == 'buy'">
                                <td>
                                    <strong>Institutional Price</strong>:
                                </td>
                                <td>{{ institutionalPrice }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <small v-if="stock.exchange == 'LSE'" class="d-block mb-3">We don't have real time prices for this stock at the moment. All prices here are based on the last close price. When submitting an trade, we will confirm the actual price with you.</small>

                    <div class="form-group">
                        <label class="form-label">Shares</label>
                        <input type="number" class="form-control" :class="{'is-invalid': fields.shares.error}" v-model="fields.shares.value" placeholder="Enter the amount of shares" required>

                        <span class="invalid-feedback" role="alert" v-if="fields.shares.error">
                            <strong>{{ fields.shares.error }}</strong>
                        </span>

                        <small>Your account manager will contact you as soon as possible to confirm best price.</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary btn-rounded btn-animated" @click.prevent="trade">
                            <span v-if="!loading.trade && action == 'buy'">Buy</span>
                            <span v-if="!loading.trade && action == 'sell'">Sell</span>
                            <div class="loader" v-if="loading.trade"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Formatting } from '../../mixins/Formatting';

    export default {

        data(){
            return {
                loading: {
                    stock: true,
                    trade: false,
                },
                completed: false,
                stock: {},
                fields: {
                    shares: {
                        value: 0,
                        error: null,
                    },
                },
                axios: {
                    source: null,
                },
            }
        },

        mixins: [
            Formatting,
        ],

        methods: {

            trade(){

                /**
                 * Clear errors
                 */
                this.fields.shares.error = null;

                /**
                 * Start loadign
                 */
                this.loading.trade = true;

                /**
                 * Make trade
                 */
                axios({
                    method: 'post',
                    url: '/api/stocks/' + this.symbol + '/' + this.action,
                    data: {
                        shares: this.fields.shares.value,
                        price: this.stock.price,
                        institutional_price: this.stock.institutional_price,
                    },
                })
                .then(response => {

                    /**
                     * Stop loading and show confirmatiuon screen
                     */
                    this.loading.trade = false;
                    this.completed = true;

                })
                .catch(error => {

                    /**
                     * Stop loading
                     */
                    this.loading.trade = false;

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
                            text: 'Something went wrong while buying/selling shares for this stock. Please try again',
                            progressBar: true,
                            timeout: 3000,
                        }).show();

                    }
                });

            },

        },

        computed: {

            show(){

                return this.$store.getters['modals/show']('trade');

            },

            showStockDetails(){

                return !this.loading.stock && !this.completed;

            },

            showStockDetailsLoader(){

                return this.loading.stock && !this.completed;

            },

            showTradeCompleted(){

                return this.completed;

            },

            symbol(){

                return this.$store.getters['modals/data']('trade').symbol;

            },

            action(){

                return this.$store.getters['modals/data']('trade').action;

            },

            price(){

                return this.formatPrice(this.stock.price, this.stock.currency);

            },

            institutionalPrice(){

                return this.formatPrice(this.stock.institutional_price, this.stock.currency);

            }

        },

        mounted(){

            /**
             * Listen to bootstrap modal events.
             */
            $(this.$refs.modal).on('hidden.bs.modal', () => {

                /**
                 * Cancel loading stock
                 */
                this.axios.source.cancel('Loading stock canceled by closing the modal.');

                /**
                 * Update Vuex
                 */
                this.$store.commit('modals/toggle', {
                    modal: 'trade',
                    show: false,
                    data: {},
                });

                /**
                 * Reset data
                 */
                this.loading = {
                    stock: true,
                    trade: false,
                };
                this.stock = {};
                this.completed = false;
                this.fields.shares.value = 0;
                this.fields.shares.error = null;

            });

        },

        watch: {

            show(value){

                if(value){

                    /**
                     * Show Modal
                     */
                    $(this.$refs.modal).modal('show');

                    /**
                     * Create new axios source
                     */
                    this.axios.source = axios.CancelToken.source();

                    /**
                     * Load Stock
                     */
                    axios({
                        method: 'get',
                        url: '/api/stocks/' + this.symbol,
                        cancelToken: this.axios.source.token
                    })
                    .then(response => {

                        /**
                         * Set Stock
                         */
                        this.stock = response.data.data;

                        /**
                         * Stop loading
                         */
                        this.loading.stock = false;

                    })
                    .catch(error => {

                        if(axios.isCancel(error)) {

                            console.log('Request canceled', error.message);

                        } else {

                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: 'Something went wrong while loading the stock information.',
                                progressBar: true,
                                timeout: 3000,
                            }).show();

                        }

                    });

                }

            }

        }

    }
</script>
