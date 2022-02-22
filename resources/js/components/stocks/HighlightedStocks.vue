<template>
    <div class="row highlighted-stocks">
        <HighlightedStock
            :loading="loading"
            :data="stock"
            :key="stock.symbol"
            v-for="stock in stocks"
        />
    </div>
</template>

<script>

    import HighlightedStock from './HighlightedStock.vue';

    export default {

        components: {
            HighlightedStock,
        },

        mounted() {

            /**
             * Load Data
             */
            axios({
                method: 'get',
                url: '/api/stocks/highlights',
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
                    text: 'Something went wrong while loading the highlighted stocks.',
                    progressBar: true,
                    timeout: 3000,
                }).show();

            });

        },

        data(){
            return {
                loading: true,
                stocks: [
                    {},
                    {},
                    {},
                    {},
                ],
            }
        }

    }

</script>
