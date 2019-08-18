
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
Vue.component( 'phone', () => import(/* webpackChunkName: "phone" */ './components/Inputs/Phone.vue'));
Vue.component( 'timepicker', () => import(/* webpackChunkName: "timepicker" */ './components/Inputs/Timepicker.vue'));
Vue.component( 'stationpicker', () => import(/* webpackChunkName: "stationpicker" */ './components/Inputs/Stationpicker.vue'));
Vue.component( 'userpicker', () => import(/* webpackChunkName: "userpicker" */ './components/Inputs/Userpicker.vue'));
Vue.component( 'datepicker', () => import(/* webpackChunkName: "datepicker" */ './components/Inputs/Datepicker.vue'));

// Custom page input
Vue.component( 'input-stations', () => import(/* webpackChunkName: "input-stations" */ './components/Pages/Tickets/Components/InputStations.vue'));
Vue.component( 'input-date-time', () => import(/* webpackChunkName: "input-date-time" */ './components/Pages/Tickets/Components/InputDateTime.vue'));

/**
 * Form components
 */
Vue.component( 'input-prepend-append', () => import(/* webpackChunkName: "input-prepend-append" */ './components/Forms/input-prepend-append.vue'));
Vue.component( 'input-text', () => import(/* webpackChunkName: "input-text" */ './components/Forms/input-text.vue'));
Vue.component( 'input-textarea', () => import(/* webpackChunkName: "input-textarea" */ './components/Forms/input-textarea.vue'));
Vue.component( 'input-textarea-basic', () => import(/* webpackChunkName: "input-textarea-basic" */ './components/Forms/input-textarea-basic.vue'));
Vue.component( 'input-select', () => import(/* webpackChunkName: "input-select" */ './components/Forms/input-select.vue'));
Vue.component( 'input-currency', () => import(/* webpackChunkName: "input-currency" */ './components/Forms/input-currency.vue'));
Vue.component( 'input-date', () => import(/* webpackChunkName: "input-date" */ './components/Forms/input-date.vue'));
Vue.component( 'input-time', () => import(/* webpackChunkName: "input-time" */ './components/Forms/input-time.vue'));
Vue.component( 'input-country', () => import(/* webpackChunkName: "input-country" */ './components/Forms/input-country.vue'));
Vue.component( 'input-image', () => import(/* webpackChunkName: "input-image" */ './components/Forms/input-image.vue'));
Vue.component( 'input-station', () => import(/* webpackChunkName: "input-station" */ './components/Forms/input-station.vue'));
Vue.component( 'vue-form', () => import(/* webpackChunkName: "vue-form" */ './components/Forms/vue-form.vue'));


/**
 * Table components
 */
Vue.component( 'smart-table', () => import(/* webpackChunkName: "smart-table" */ './components/Tables/smart-table.vue'));


/**
 * Shared components
 */

Vue.component( 'sandwich', () => import(/* webpackChunkName: "sandwich" */ './components/Shared/Sandwich.vue'));
Vue.component( 'loader', () => import(/* webpackChunkName: "loader" */ './components/Shared/Loader.vue'));
Vue.component( 'modal', () => import(/* webpackChunkName: "modal" */ './components/Shared/Modal.vue'));
Vue.component( 'flash', () => import(/* webpackChunkName: "flash" */ './components/Shared/Flash.vue'));
Vue.component( 'dropdown-menu', () => import(/* webpackChunkName: "dropdown-menu" */ './components/PTB/DropDownMenu.vue'));

/**
 * PTB specific components
 */

Vue.component( 'reviews', () => import(/* webpackChunkName: "reviews" */ './components/PTB/Review.vue'));
Vue.component( 'notifications', () => import(/* webpackChunkName: "notifications" */ './components/PTB/Notifications.vue'));
Vue.component( 'settings', () => import(/* webpackChunkName: "settings" */ './components/PTB/Settings.vue'));
Vue.component( 'ticket', () => import(/* webpackChunkName: "ticket" */ './components/PTB/Ticket.vue'));
Vue.component( 'horizontal-ticket', () => import(/* webpackChunkName: "horizontal-ticket" */ './components/PTB/HorizontalTicket.vue'));
Vue.component( 'ticket-mini', () => import(/* webpackChunkName: "ticket-mini" */ './components/PTB/Ticket-Mini.vue'));
Vue.component( 'blog-posts', () => import(/* webpackChunkName: "blog-posts" */ './components/PTB/BlogPosts.vue'));
Vue.component( 'alert-modal', () => import(/* webpackChunkName: "alert-modal" */ './components/PTB/AlertModal.vue'));
Vue.component( 'call-modal', () => import(/* webpackChunkName: "call-modal" */ './components/PTB/CallModal.vue'));


/**
 * Page components
 */

Vue.component( 'auth', () => import(/* webpackChunkName: "auth" */ './components/Pages/Auth/Auth.vue'));
Vue.component( 'social-password', () => import(/* webpackChunkName: "social-password" */ './components/Pages/Auth/SocialPassword.vue'));
Vue.component( 'help', () => import(/* webpackChunkName: "help" */ './components/Pages/Help/Faq.vue'));

Vue.component( 'sell-ticket', () => import(/* webpackChunkName: "sell-ticket" */ './components/Pages/Tickets/Sell.vue'));
Vue.component( 'my-tickets', () => import(/* webpackChunkName: "my-tickets" */ './components/Pages/Tickets/Mytickets.vue'));
Vue.component( 'buy-ticket', () => import(/* webpackChunkName: "buy-ticket" */ './components/Pages/Tickets/Buy.vue'));
Vue.component( 'train-results', () => import(/* webpackChunkName: "train-results" */ './components/Pages/Tickets/Components/TrainResults.vue'));


Vue.component( 'home-search', () => import(/* webpackChunkName: "home-search" */ './components/Pages/Welcome/HomeSearch.vue'));
Vue.component( 'home-buyer-seller-info', () => import(/* webpackChunkName: "home-buyer-seller-info" */ './components/Pages/Welcome/BuyerSellerInfo.vue'));
Vue.component( 'my-alerts', () => import(/* webpackChunkName: "my-alerts" */ './components/Pages/Alerts/Alerts.vue'));


Vue.component( 'messages-home', () => import(/* webpackChunkName: "messages-home" */ './components/Pages/Message/Home.vue'));
Vue.component( 'discussion', () => import(/* webpackChunkName: "discussion" */ './components/Pages/Message/Discussion.vue'));

// Unique components (used in one place only)
Vue.component( 'change-password', () => import(/* webpackChunkName: "change-password" */ './components/Pages/Profile/ChangePassword.vue'));
Vue.component( 'delete-account', () => import(/* webpackChunkName: "delete-account" */ './components/Pages/Profile/DeleteAccount.vue'));





