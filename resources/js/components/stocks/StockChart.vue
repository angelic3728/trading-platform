<template>
    <div class="card mt-4 mt-lg-5">
        <div class="card-chart">
            <div class="chart">
                <canvas ref="chart" style="height: 100%; width: 100%;"></canvas>
            </div>

            <div class="company_details">
                <h1>{{ companyName }} <span>({{ symbol }})</span></h1>
                <div class="d-flex align-items-center">
                    <h2>{{ formattedPrice }}</h2>
                    <div :class="changePercentageClass" v-if="showChangePercentage">{{ formattedChangePercentage }}</div>
                    <tooltip text="This stock has no real time pricing at the moment. All prices are based on the last closing price." v-if="exchange == 'LSE'" />
                </div>
            </div>

            <div class="btn-primary buy" @click="buy">Buy Shares</div>

            <div class="chart-ranges">
                <li :class="[{'active': item == range}, 'range-' + item]" v-for="item in ranges" @click="updateChartData(item)">{{ item }}</li>
            </div>

            <div class="loader-holder" v-if="loading">
                <div class="loader"></div>
            </div>
        </div>

        <div class="card-body" style="border-top: 1px solid #E4E7EB" v-if="source == 'custom'">
            <div class="text-right">
                <a :href="link" target="_blank">Click here for more information about this stock</a>
            </div>
        </div>
    </div>
</template>

<script>
    import { Formatting } from '../../mixins/Formatting';

    export default {

        mixins: [
            Formatting,
        ],

        props: ['symbol', 'companyName', 'price', 'changePercentage', 'exchange', 'currency', 'link', 'source'],

        data(){
            return {
                range: '1m',
                loading: true,
                chart: null,
            }
        },

        computed: {

            ranges(){

                if(this.source == 'iex' && this.exchange == 'NYSE'){

                    return ['1d', '1m', '3m', '6m', 'ytd', '1y', '2y', '5y'];

                } else {

                    return ['1m', '3m', '6m', 'ytd', '1y', '2y', '5y'];

                }

            },

            formattedPrice(){

                return this.formatPrice(this.price, this.currency);

            },

            formattedChangePercentage(){

                return this.formatPercentage(this.changePercentage);

            },

            changePercentageClass(){

                if(this.changePercentage >= 0){

                    return 'change-percentage-positive';

                } else if(this.changePercentage < 0){

                    return 'change-percentage-negative';

                }

            },

            showChangePercentage(){

                return this.changePercentage != null;

            },

        },

        mounted(){

            this.getChartData();

        },

        methods: {

            buy(){

                this.$store.commit('modals/toggle', {
                    modal: 'trade',
                    show: true,
                    data: {
                        symbol: this.symbol,
                        action: 'buy',
                    },
                });

            },

            updateChartData(range){

                /**
                 * Set new chart range
                 */
                this.range = range;

                /**
                 * Start loading
                 */
                this.loading = true;

                /**
                 * Get chart data
                 */
                this.getChartData();

            },

            getChartData(){

                /**
                 * Load Data
                 */
                axios({
                    method: 'get',
                    url: '/api/stocks/chart/' + this.symbol + '/' + this.range,
                })
                .then(response => {

                    /**
                     * Stop loading
                     */
                    this.loading = false;

                    /**
                     * Create or update chart
                     */
                    if(this.chart){

                        this.updateChart(response.data.data);

                    } else {

                        this.createChart(response.data.data);

                    }

                })
                .catch(error => {

                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Something went wrong while loading the graph.',
                        progressBar: true,
                        timeout: 3000,
                    }).show();

                });

            },

            createChart(chart_data){

                /**
                 * Label text
                 */
                let label = this.range == '1d' ? 'Open Price' : 'Close Price';

                /**
                 * Determine what price is needed
                 */
                let price_key = this.range == '1d' ? 'open' : 'close';

                /**
                 * Prepare Data
                 */
                let data = collect(chart_data)
                              .filter((value, key) => {
                                  return value[price_key] != null;
                              })
                              .pluck(price_key)
                              .all();

                /**
                 * Prepare labels
                 */
                let labels = collect(chart_data)
                                .filter((value, key) => {
                                    return value[price_key] != null;
                                })
                                .pluck('date')
                                .all();

                /**
                 * Create Chart
                 */
                this.chart = new Chart(this.$refs.chart, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label,
                            data,
                            backgroundColor: '#CCEBD6',
                            borderColor: '#1EA54A',
                            pointBackgroundColor: '#CCEBD6',
                            pointBorderColor: '#1EA54A',
                        }]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: (tooltipItems, data) => {
                                    return data.datasets[tooltipItems.datasetIndex].label + ": " + this.formatPrice(tooltipItems.yLabel, this.currency);
                                }
                            },
                            intersect: false
                        },
                        layout: {
                            padding: {
                                top: 75,
                            }
                        },
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false,
                                    drawTicks: false,
                                },
                                ticks: {
                                    display:  false,
                                    padding: 0,
                                },
                            }],
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false,
                                    drawTicks: false,
                                },
                                ticks: {
                                    display:  false,
                                    padding: 0,
                                },
                            }],
                        },
                    },
                });

            },

            updateChart(chart_data){

                /**
                 * Label text
                 */
                let label = this.range == '1d' ? 'Open Price' : 'Close Price';

                /**
                 * Determine what price is needed
                 */
                let price_key = this.range == '1d' ? 'open' : 'close';

                /**
                 * Prepare Data
                 */
                let data = collect(chart_data)
                              .filter((value, key) => {
                                  return value[price_key] != null;
                              })
                              .pluck(price_key)
                              .all();

                /**
                 * Prepare labels
                 */
                let labels = collect(chart_data)
                                .filter((value, key) => {
                                    return value[price_key] != null;
                                })
                                .pluck('date')
                                .all();

                /**
                 * Update Labels
                 */
                this.chart.data.labels = labels;

                /**
                 * Update Data
                 */
                this.chart.data.datasets.forEach((dataset) => {

                    dataset.data = data;
                    dataset.label = label;

                });

                /**
                 * Render Chart
                 */
                this.chart.update(0);

            }

        }

    }
</script>
