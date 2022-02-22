/**
 * Load all dependancy's
 */
require('./bootstrap');

/**
 * Vue
 */
window.Vue = require('vue');


/**
 * Load Components
 */
Vue.component('Tooltip', require('./components/Tooltip.vue').default);
Vue.component('HighlightedStocks', require('./components/stocks/HighlightedStocks.vue').default);
Vue.component('Portfolio', require('./components/stocks/Portfolio.vue').default);
Vue.component('StockChart', require('./components/stocks/StockChart.vue').default);
Vue.component('HeaderSearch', require('./components/HeaderSearch.vue').default);
Vue.component('UploadDocumentButton', require('./components/buttons/UploadDocument.vue').default);
Vue.component('UploadDocumentModal', require('./components/modals/UploadDocument.vue').default);
Vue.component('TradeModal', require('./components/modals/Trade.vue').default);
Vue.component('Avatar', require('./components/Avatar.vue').default);
Vue.component('Widget', require('./components/stocks/Widget.vue').default);
Vue.component('WidgetStock', require('./components/stocks/WidgetStock.vue').default);
Vue.component('News', require('./components/news/News.vue').default);
Vue.component('NewsArticle', require('./components/news/NewsArticle.vue').default);

/**
 * Get Vuex Store
 */
import store from './store';

/**
 * Create App
 */
const app = new Vue({
    el: '#app',
    store,
});
