<template>
    <div class="search">
        <input type="text" placeholder="Search Stocks" class="form-control" v-model="search">
        <div class="search-icon">
            <img src="/icons/header/search.svg" v-if="!loading" />
            <div class="loader" v-if="loading"></div>
        </div>
        <div class="results" v-if="showResults">
            <a :href="'/stocks/' + item.symbol" v-for="item in results">{{ item.symbol}} - <span>{{ item.company_name }}</span></a>
        </div>
        <div class="no-results" v-if="showNoResultsMessage">
            No stocks found
        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return {
                search: '',
                stocks: [],
                loading: false,
            }
        },

        computed: {

            showResults(){

                return !_.isEmpty(this.results);

            },

            showNoResultsMessage(){

                return _.isEmpty(this.results) && this.loading == false && this.search != '' && this.search != null;

            },

            results(){

                /**
                 * If there is no search return nothing
                 */
                if(this.search == '' || this.search == null){

                    return [];

                }

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

                return stocks.take(10).toArray();

            }

        },

        watch: {

            search(query){

                /**
                 * Get stocks if they aren't loaded
                 */
                if(_.isEmpty(this.stocks)){

                    /**
                     * Start loading
                     */
                    this.loading = true

                    /**
                     * Load Data
                     */
                    axios({
                        method: 'get',
                        url: '/api/stocks/all',
                    })
                    .then(response => {

                        /**
                         * Stop loading
                         */
                        this.loading = false;

                        /**
                         * Update stocks
                         */
                        this.stocks = response.data.data;

                    })
                    .catch(error => {

                        /**
                         * Stop loading
                         */
                        this.loading = false;

                    });

                }

            },

        },

    }
</script>
