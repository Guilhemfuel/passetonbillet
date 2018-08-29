
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
 * Note that ptb uses elementUi vue components (so we import it here)
 */

Vue.component('vue-select', require('vue-select'));
Vue.component('datepicker', require('vuejs-datepicker'));

// Inputs - TODO: delete/convert components to nue format
Vue.component('phone', require('./components/Inputs/Phone.vue'));
Vue.component('timepicker', require('./components/Inputs/Timepicker.vue'));
Vue.component('stationpicker', require('./components/Inputs/Stationpicker.vue'));
Vue.component('userpicker', require('./components/Inputs/Userpicker.vue'));
Vue.component('datepicker', require('./components/Inputs/Datepicker.vue'));

// Custom page input
Vue.component('input-stations', require('./components/Pages/Tickets/Components/InputStations.vue'));
Vue.component('input-date-time', require('./components/Pages/Tickets/Components/InputDateTime.vue'));

/**
 * Form components
 */


Vue.component('input-text', require('./components/Forms/input-text.vue'));
Vue.component('input-textarea', require('./components/Forms/input-textarea.vue'));
Vue.component('input-textarea-basic', require('./components/Forms/input-textarea-basic.vue'));
Vue.component('input-select', require('./components/Forms/input-select.vue'));
Vue.component('input-currency', require('./components/Forms/input-currency.vue'));
Vue.component('input-date', require('./components/Forms/input-date.vue'));
Vue.component('input-time', require('./components/Forms/input-time.vue'));
Vue.component('input-country', require('./components/Forms/input-country.vue'));
Vue.component('input-image', require('./components/Forms/input-image.vue'));
Vue.component('input-station', require('./components/Forms/input-station.vue'));
Vue.component('vue-form', require('./components/Forms/vue-form.vue'));

/**
 * Table components
 */

Vue.component('smart-table', require('./components/Tables/smart-table.vue'));


/**
 * Shared components
 */

Vue.component('sandwich', require('./components/Shared/Sandwich.vue'));
Vue.component('loader', require('./components/Shared/Loader.vue'));
Vue.component('modal', require('./components/Shared/Modal.vue'));
Vue.component('flash', require('./components/Shared/Flash.vue'));
Vue.component('dropdown-menu', require('./components/PTB/DropDownMenu.vue'));

/**
 * PTB specific components
 */
Vue.component('notifications', require('./components/PTB/Notifications.vue'));
Vue.component('settings', require('./components/PTB/Settings.vue'));
Vue.component('ticket', require('./components/PTB/Ticket.vue'));
Vue.component('ticket-mini', require('./components/PTB/Ticket-Mini.vue'));

/**
 * Page components
 */
Vue.component('auth', require('./components/Pages/Auth/Auth.vue'));
Vue.component('social-password', require('./components/Pages/Auth/SocialPassword.vue'));

Vue.component('sell-ticket', require('./components/Pages/Tickets/Sell.vue'));
Vue.component('manual-sell-ticket', require('./components/Pages/Tickets/Components/ManualSell.vue'));

Vue.component('buy-ticket', require('./components/Pages/Tickets/Buy.vue'));
Vue.component('my-tickets', require('./components/Pages/Tickets/Mytickets.vue'));

Vue.component('home-search', require('./components/Pages/Welcome/HomeSearch.vue'));
Vue.component('home-buyer-seller-info', require('./components/Pages/Welcome/BuyerSellerInfo.vue'));

Vue.component('messages-home', require('./components/Pages/Message/Home.vue'));
Vue.component('discussion', require('./components/Pages/Message/Discussion.vue'));


// Unique components (used in one place only)
Vue.component('change-password', require('./components/Pages/Profile/ChangePassword.vue'));




