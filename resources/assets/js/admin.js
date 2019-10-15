/*!

 =========================================================
 * Admin Includes
 =========================================================

 */

require('./app');

// CRUD Tables
Vue.component('tickets-table', require('./components/Pages/Admin/CRUD/Tickets/Table.vue').default);
Vue.component('pretty-json', require('./components/Shared/Json.vue').default);

// Charts
Vue.component('line-chart', require('./components/Charts/line-chart.vue').default);
Vue.component('doughnut-chart', require('./components/Charts/doughnut-chart.vue').default);
Vue.component('input-date-admin', require('./components/Forms/input-date-admin.vue').default);


// Pages
Vue.component('stats', require('./components/Pages/Admin/unique/stats.vue').default);
Vue.component('page-builder', require('./components/Pages/Admin/unique/pagebuilder.vue').default);
Vue.component('home-stat', require('./components/Pages/Admin/HomeStat.vue').default);


