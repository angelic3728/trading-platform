<template>
    <tr>
        <td class="symbol-with-company-name clickable" @click="showStockDetails">
            <span>
                {{ data.symbol }}
                <small>{{ data.company_name }}</small>
            </span>
        </td>
        <td nowrap>
            {{ lastPrice }}
            <tooltip text="This stock has no real time pricing at the moment. All prices are based on the last closing price." v-if="data.exchange == 'LSE'" />
        </td>
        <td :class="changePercentageClass">{{ changePercentage }}</td>
        <td>{{ institutionalPrice }}</td>
        <td>{{ data.shares }}</td>
        <td>{{ value }}</td>
        <td nowrap>
            <a href="#" @click.prevent="trade('sell')">Sell</a> / <a href="#" @click="trade('buy')">Buy</a>
        </td>
    </tr>
</template>

<script>
    import { Formatting } from '../../mixins/Formatting';

    export default {

        mixins: [
            Formatting,
        ],

        props: ['data'],

        methods: {

            showStockDetails(){

                window.location.href = this.url;

            },

            trade(action){

                this.$store.commit('modals/toggle', {
                    modal: 'trade',
                    show: true,
                    data: {
                        symbol: this.data.symbol,
                        action,
                    },
                });

            }

        },

        computed: {

            url(){

                return '/stocks/' + this.data.symbol;

            },

            lastPrice(){

                return this.formatPrice(this.data.last_price, this.data.currency);

            },

            institutionalPrice(){

                return this.formatPrice(this.data.institutional_price, this.data.currency);

            },

            value(){

                return this.formatPrice(this.data.value, this.data.currency);

            },

            changePercentage(){

                /**
                 * If there is no change percentage, return null
                 * This happens with LSE stocks
                 */
                if(this.data.change_percentage == null){

                    return null;

                }

                return this.formatPercentage(this.data.change_percentage);

            },

            changePercentageClass(){

                if(this.data.change_percentage >= 0){

                    return 'change-percentage-positive';

                } else if(this.data.change_percentage < 0){

                    return 'change-percentage-negative';

                }

            }

        }

    }
</script>
