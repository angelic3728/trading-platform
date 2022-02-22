<template>
    <a :href="url" class="widget-stock">
        <div class="widget-company-name">{{ companyName }}</div>
        <div class="widget-details">
            <div class="widget-price">
                {{ priceFormatted }}
                <span class="widget-change-percentage" :class="changePercentageClass">{{ changePercentageFormatted }}</span>
            </div>
            <div class="widget-chart">
                <canvas ref="chart"></canvas>
            </div>
        </div>
    </a>
</template>

<script>
    import { Formatting } from '../../mixins/Formatting';

    export default {

        mixins: [
            Formatting
        ],

        props: {
            symbol: {
                type: String,
            },
            companyName: {
                type: String,
            },
            price: {
                type: Number,
            },
            changePercentage: {
                type: Number,
            },
            chart: {
                type: Array,
            },
            currency: {
                type: String,
            }
        },
        mounted(){

            /**
             * Prepare labels and data
             */
            let labels = collect(this.chart).pluck('date').all();
            let data = collect(this.chart).pluck('close').all();

            /**
             * Create Chart
             */
            new Chart(this.$refs.chart, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        data,
                        backgroundColor: [
                            '#CCEBD6',
                        ],
                        borderColor: [
                            '#1EA54A'
                        ],
                        borderWidth: 1,
                        pointRadius: 0,
                    }]
                },
                options: {
                    tooltips: {
                        enabled: false,
                    },
                    responsive: true,
                    maintainAspectRatio: false,
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

        computed: {

            url(){

                return '/stocks/' + this.symbol;

            },

            changeIsPositive(){

                return this.changePercentage >= 0

            },

            changePercentageFormatted(){

                return this.formatPercentage(this.changePercentage);

            },

            changePercentageClass(){

                if(this.changePercentage > 0){

                    return 'positive';

                } else if(this.changePercentage < 0){

                    return 'negative';

                }

            },

            showChangePercentage(){

                return this.changePercentage != null;

            },

            priceFormatted(){

                return this.formatPrice(this.price, this.currency);

            },

        }

    }
</script>
