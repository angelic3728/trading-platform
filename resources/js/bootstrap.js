/**
 * Make library's available
 */
window._ = require('lodash');
window.Noty = require('noty');
window.numeral = require('numeral');
window.moment = require('moment');
window.collect = require('collect.js');
window.Chart = require('chart.js');

/**
 * Set ChartJS Globals
 */
Chart.defaults.global.maintainAspectRatio = false;
Chart.defaults.global.elements.line.tension = 0;
Chart.defaults.global.legend.display = false;
Chart.defaults.global.tooltips.enabled = true;
Chart.defaults.global.tooltips.mode = 'single';
Chart.defaults.global.tooltips.backgroundColor = '#1EA54A';
Chart.defaults.global.tooltips.bodyFontColor = 'rgba(255, 255, 255, 0.8)';
Chart.defaults.global.tooltips.bodyFontFamily = 'Open Sans';
Chart.defaults.global.tooltips.titleFontFamily = 'Open Sans';
Chart.defaults.global.tooltips.titleFontSize = 13;
Chart.defaults.global.tooltips.titleMarginBottom = 6;
Chart.defaults.global.tooltips.displayColors = false;
Chart.defaults.global.tooltips.cornerRadius = 0;
Chart.defaults.global.tooltips.xPadding = 10;
Chart.defaults.global.tooltips.yPadding = 10;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
