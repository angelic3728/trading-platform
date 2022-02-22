<template>
    <div class="col-6 col-md-3">
        <a :href="url" class="card stock">
            <div class="chart" :class="{'loading': loading}">
                <canvas ref="chart" v-show="!loading" style="height: 100%; width: 100%;"></canvas>
                <div class="loader" v-if="loading"></div>
            </div>
            <div class="card-body">
                <h4 class="d-none d-lg-block" :class="{'loading': loading, 'loading-text-animation': loading}">{{ data.company_name }}</h4>
                <h4 class="d-lg-none d-xl-none" :class="{'loading': loading, 'loading-text-animation': loading}">{{ data.symbol }}</h4>
                <div class="price" :class="{'loading': loading, 'loading-text-animation': loading}">
                    {{ price }}
                    <span :class="changePercentageClass" v-if="showChangePercentage">{{ changePercentage }}</span>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
    import { Formatting } from '../../mixins/Formatting';

    export default {

        props: ['data', 'loading'],

        mixins: [
            Formatting
        ],

        data(){
            return {
                chart: null,
            }
        },

        mounted(){

            if(!this.loading){

                /**
                 * Prepare labels and data
                 */
                let labels = collect(this.data.chart).pluck('date').all();
                let data = collect(this.data.chart).pluck('close').all();

                this.chart = new Chart(this.$refs.chart, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Close Price',
                            data,
                            backgroundColor: [
                                '#CCEBD6',
                            ],
                            borderColor: [
                                '#1EA54A'
                            ],
                        }]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: (tooltipItems, data) => {
                                    return data.datasets[tooltipItems.datasetIndex].label + ": " + this.formatPrice(tooltipItems.yLabel, this.data.currency);
                                }
                            },
                        },
                        layout: {
                            padding: {
                                top: 10,
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

            }

        },

        computed: {

            url(){

                return '/stocks/' + this.data.symbol;

            },

            changeIsPositive(){

                return this.data.change_percentage >= 0

            },

            changePercentage(){

                return this.formatPercentage(this.data.change_percentage);

            },

            changePercentageClass(){

                if(this.data.change_percentage > 0){

                    return 'change-percentage-positive';

                } else if(this.data.change_percentage < 0){

                    return 'change-percentage-negative';

                }

            },

            showChangePercentage(){

                return this.data.change_percentage != null;

            },

            price(){

                return this.formatPrice(this.data.price, this.data.currency);

            },

        }

    }
</script>
