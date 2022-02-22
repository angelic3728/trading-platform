<template>
    <div class="card my-investments">
        <div class="card-header" ref="header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0">My Portfolio</h4>
                </div>
                <div class="col-auto d-none d-sm-flex">
                    <div class="search">
                        <input type="text" class="form-control" placeholder="Search" v-model="search">
                        <div class="search-icon">
                            <img src="/icons/table/search.svg" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-loader" v-if="loading">
            <div class="loader"></div>
        </div>

        <div class="table-holder" :style="tableHolderStyle" v-if="!loading">
            <table class="table">
                <thead class="thead-light">
                    <th>Company</th>
                    <th nowrap>Last Price</th>
                    <th>Change</th>
                    <th nowrap>Institutional Price</th>
                    <th>Shares</th>
                    <th>Value</th>
                    <th></th>
                </thead>

                <tbody>
                    <tr is="PortfolioStock" :data="stock" :key="stock.symbol" v-for="stock in filteredStocks"></tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    import PortfolioStock from './PortfolioStock.vue';

    export default {

        components: {
            PortfolioStock,
        },

        computed: {

            tableHolderStyle(){

                /**
                 * If screensize isn't smaller than 991.98 and the table height is bigger than one
                 */
                if(window.innerWidth >= 992 && this.tableHeight > 0){

                    return {
                        height: this.tableHeight + 'px',
                    }

                } else {

                    return {};

                }

            },

            filteredStocks(){

                /**
                 * Make collection from stocks
                 */
                let stocks = collect(this.stocks);

                /**
                 * Filter stocks if search is enabled
                 */
                if(this.search != ''){

                    /**
                     * Prepare search Regex
                     */
                    let search_regex = new RegExp(this.search, "i");

                    /**
                     * Filter stocks. Check if symbol or company matches the search query
                     */
                    stocks = stocks.filter((value, key) => {

                        return value.symbol.match(search_regex) || value.company_name.match(search_regex);

                    });

                }

                return stocks.all();

            },

        },

        mounted() {

            // TODO: only do this when responsive

            /**
             * Get heights
             */
            let header_height = this.$refs.header.clientHeight;
            let balance = document.getElementById('balance').clientHeight;
            let account_manager = document.getElementById('account-manager').clientHeight;

            /**
             * Set new max-height for table
             *
             * Add up the balance and account manager. They have 25px margin between them
             * Then subtract the header-height of this card and the borders (3px)
             */
            this.tableHeight = (balance + account_manager + 25) - (header_height + 4);

            /**
             * Load Data
             */
            axios({
                method: 'get',
                url: '/api/stocks/investments',
            })
            .then(response => {

                /**
                 * Show Stocks
                 */
                this.stocks = response.data.data;

                /**
                 * Stop loading
                 */
                this.loading = false;

            })
            .catch(error => {

                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: 'Something went wrong while loading your investments.',
                    progressBar: true,
                    timeout: 3000,
                }).show();

            });

        },

        data(){
            return {
                loading: true,
                stocks: [],
                search: '',
                tableHeight: 0,
            }
        }

    }

</script>
