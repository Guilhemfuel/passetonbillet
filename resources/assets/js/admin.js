/*!

 =========================================================
 * Admin Includes
 =========================================================

 */

require('./app');

// CRUD Tables
Vue.component('tickets-table', require('./components/Pages/Admin/CRUD/Tickets/Table.vue'));
Vue.component('pretty-json', require('./components/Shared/Json.vue'));

// Charts
Vue.component('line-chart', require('./components/Charts/line-chart.vue'));
Vue.component('doughnut-chart', require('./components/Charts/doughnut-chart.vue'));

// Pages
Vue.component('stats', require('./components/Pages/Admin/unique/stats.vue'));


