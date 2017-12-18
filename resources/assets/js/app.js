
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 *
 * Note that lastar uses elementUi vue components (so we import it here)
 */

Vue.component('cleave', require('vue-cleave'));
Vue.component('vue-select', require('vue-select'));
Vue.component('datepicker', require('vuejs-datepicker'));

// Inputs
Vue.component('phone', require('./components/Inputs/Phone.vue'));
Vue.component('timepicker', require('./components/Inputs/Timepicker.vue'));
Vue.component('stationpicker', require('./components/Inputs/Stationpicker.vue'));
Vue.component('userpicker', require('./components/Inputs/Userpicker.vue'));
Vue.component('datepicker', require('./components/Inputs/Datepicker.vue'));
Vue.component('trippicker', require('./components/Inputs/Trippicker.vue'));
Vue.component('datetimepicker', require('./components/Inputs/Datetimepicker.vue'));

// Shared
Vue.component('sandwich', require('./components/Shared/Sandwich.vue'));
Vue.component('loader', require('./components/Shared/Loader.vue'));
Vue.component('modal', require('./components/Shared/Modal.vue'));
Vue.component('flash', require('./components/Shared/Flash.vue'));
Vue.component('sidebar', require('./components/Shared/Sidebar.vue'));

// Lastar
Vue.component('ticket', require('./components/Lastar/Ticket.vue'));

// Pages
Vue.component('auth', require('./components/Pages/Auth.vue'));
Vue.component('sell-ticket', require('./components/Pages/Tickets/Sell.vue'));
Vue.component('buy-ticket', require('./components/Pages/Tickets/Buy.vue'));
Vue.component('my-tickets', require('./components/Pages/Tickets/Mytickets.vue'));

// Unique components (used in one place only)
Vue.component('change-password', require('./components/Pages/Profile/ChangePassword.vue'));




