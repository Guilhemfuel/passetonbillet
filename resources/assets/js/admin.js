/*!

 =========================================================
 * Admin Includes
 =========================================================

 */

require('./app');

// CRUD Tables
Vue.component('tickets-table', require('./components/Pages/Admin/CRUD/Tickets/Table.vue'));
Vue.component('pretty-json', require('./components/Shared/Json.vue'));

