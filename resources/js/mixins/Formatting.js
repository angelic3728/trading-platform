export const Formatting = {

    methods: {

        formatPrice(price, currency){

            switch (currency) {

                case 'USD':
                    return numeral(price).format('$0,0.00')
                    break;

                case 'GBP':
                    return numeral((price * 100)).format('0,0.00') + 'p';
                    break;

                default:
                    return price;
                    break;

            }

        },

        formatPercentage(percentage){

            return numeral(percentage).format('+0.00%');

        },

    }
}
