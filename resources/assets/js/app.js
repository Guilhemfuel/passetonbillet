
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

Vue.component('datepicker', require('vuejs-datepicker').default);

// Inputs - TODO: delete/convert components to nue format
Vue.component( 'phone', require(/* webpackChunkName: "phone" */ './components/Inputs/Phone.vue').default);
Vue.component( 'timepicker', require(/* webpackChunkName: "timepicker" */ './components/Inputs/Timepicker.vue').default);
Vue.component( 'stationpicker', require(/* webpackChunkName: "stationpicker" */ './components/Inputs/Stationpicker.vue').default);
Vue.component( 'userpicker', require(/* webpackChunkName: "userpicker" */ './components/Inputs/Userpicker.vue').default);
Vue.component( 'datepicker', require(/* webpackChunkName: "datepicker" */ './components/Inputs/Datepicker.vue').default);

// Custom page input
Vue.component( 'input-stations', require(/* webpackChunkName: "input-stations" */ './components/Pages/Tickets/components/InputStations.vue').default);
Vue.component( 'input-date-time', require(/* webpackChunkName: "input-date-time" */ './components/Pages/Tickets/components/InputDateTime.vue').default);

/**
 * Form components
 */
Vue.component( 'input-prepend-append', require(/* webpackChunkName: "input-prepend-append" */ './components/Forms/input-prepend-append.vue').default);
Vue.component( 'input-text', require(/* webpackChunkName: "input-text" */ './components/Forms/input-text.vue').default);
Vue.component( 'input-textarea', require(/* webpackChunkName: "input-textarea" */ './components/Forms/input-textarea.vue').default);
Vue.component( 'input-textarea-basic', require(/* webpackChunkName: "input-textarea-basic" */ './components/Forms/input-textarea-basic.vue').default);
Vue.component( 'input-select', require(/* webpackChunkName: "input-select" */ './components/Forms/input-select.vue').default);
Vue.component( 'input-currency', require(/* webpackChunkName: "input-currency" */ './components/Forms/input-currency.vue').default);
Vue.component( 'input-date', require(/* webpackChunkName: "input-date" */ './components/Forms/input-date.vue').default);
Vue.component( 'input-time', require(/* webpackChunkName: "input-time" */ './components/Forms/input-time.vue').default);
Vue.component( 'input-country', require(/* webpackChunkName: "input-country" */ './components/Forms/input-country.vue').default);
Vue.component( 'input-image', require(/* webpackChunkName: "input-image" */ './components/Forms/input-image.vue').default);
Vue.component( 'input-station', require(/* webpackChunkName: "input-station" */ './components/Forms/input-station.vue').default);
Vue.component( 'vue-form', require(/* webpackChunkName: "vue-form" */ './components/Forms/vue-form.vue').default);


/**
 * Table components
 */
Vue.component( 'smart-table', require(/* webpackChunkName: "smart-table" */ './components/Tables/smart-table.vue').default);


/**
 * Shared components
 */

Vue.component( 'ads', require(/* webpackChunkName: "ads" */ './components/Shared/Ads.vue').default);
Vue.component( 'sandwich', require(/* webpackChunkName: "sandwich" */ './components/Shared/Sandwich.vue').default);
Vue.component( 'loader', require(/* webpackChunkName: "loader" */ './components/Shared/Loader.vue').default);
Vue.component( 'modal', require(/* webpackChunkName: "modal" */ './components/Shared/Modal.vue').default);
Vue.component( 'flash', require(/* webpackChunkName: "flash" */ './components/Shared/Flash.vue').default);
Vue.component( 'dropdown-menu', require(/* webpackChunkName: "dropdown-menu" */ './components/PTB/DropDownMenu.vue').default);

/**
 * PTB specific components
 */

Vue.component( 'reviews', require(/* webpackChunkName: "reviews" */ './components/PTB/Review.vue').default);
Vue.component( 'notifications', require(/* webpackChunkName: "notifications" */ './components/PTB/Notifications.vue').default);
Vue.component( 'settings', require(/* webpackChunkName: "settings" */ './components/PTB/Settings.vue').default);
Vue.component( 'ticket', require(/* webpackChunkName: "ticket" */ './components/PTB/Ticket.vue').default);
Vue.component( 'horizontal-ticket', require(/* webpackChunkName: "horizontal-ticket" */ './components/PTB/HorizontalTicket.vue').default);
Vue.component( 'ticket-mini', require(/* webpackChunkName: "ticket-mini" */ './components/PTB/Ticket-Mini.vue').default);
Vue.component( 'blog-posts', require(/* webpackChunkName: "blog-posts" */ './components/PTB/BlogPosts.vue').default);
Vue.component( 'alert-modal', require(/* webpackChunkName: "alert-modal" */ './components/PTB/AlertModal.vue').default);
Vue.component( 'buy-modal', require(/* webpackChunkName: "buy-modal" */ './components/PTB/BuyModal.vue').default);
Vue.component( 'call-modal', require(/* webpackChunkName: "call-modal" */ './components/PTB/CallModal.vue').default);
Vue.component( 'phone-modal', require(/* webpackChunkName: "phone-modal" */ './components/PTB/PhoneModal.vue').default);
Vue.component( 'pdf-viewer', require(/* webpackChunkName: "pdf-viewer" */ './components/PTB/PdfViewer.vue').default);
Vue.component( 'share-ticket', require(/* webpackChunkName: "share-ticket" */ './components/PTB/ShareTicket.vue').default);
Vue.component( 'success-purchase-modal', require(/* webpackChunkName: "success-purchase-modal" */ './components/PTB/SuccessPurchaseModal.vue').default);


/**
 * Page components
 */

Vue.component( 'auth', require(/* webpackChunkName: "auth" */ './components/Pages/Auth/Auth.vue').default);
Vue.component( 'social-password', require(/* webpackChunkName: "social-password" */ './components/Pages/Auth/SocialPassword.vue').default);
Vue.component( 'help', require(/* webpackChunkName: "help" */ './components/Pages/Help/Faq.vue').default);

Vue.component( 'sell-ticket', require(/* webpackChunkName: "sell-ticket" */ './components/Pages/Tickets/Sell.vue').default);
Vue.component( 'my-tickets-bought', require(/* webpackChunkName: "my-tickets-bought" */ './components/Pages/Tickets/MyTicketsBought.vue').default);
Vue.component( 'my-tickets-sold', require(/* webpackChunkName: "my-tickets-sold" */ './components/Pages/Tickets/MyTicketsSold.vue').default);
Vue.component( 'my-tickets-payments', require(/* webpackChunkName: "my-tickets-payments" */ './components/Pages/Tickets/MyTicketsPayments.vue').default);
Vue.component( 'buy-ticket', require(/* webpackChunkName: "buy-ticket" */ './components/Pages/Tickets/Buy.vue').default);
Vue.component( 'train-results', require(/* webpackChunkName: "train-results" */ './components/Pages/Tickets/components/TrainResults.vue').default);

Vue.component( 'ticket-sold', require(/* webpackChunkName: "ticket-sold" */ './components/Pages/Tickets/components/TicketSold.vue').default);
Vue.component( 'ticket-bought', require(/* webpackChunkName: "ticket-bought" */ './components/Pages/Tickets/components/TicketBought.vue').default);
Vue.component( 'ticket-payment', require(/* webpackChunkName: "ticket-payment" */ './components/Pages/Tickets/components/TicketPayment.vue').default);
Vue.component( 'claim-modal-purchaser', require(/* webpackChunkName: "claim-modal-purchaser" */ './components/Pages/Tickets/components/ClaimModalPurchaser.vue').default);
Vue.component( 'claim-modal-seller', require(/* webpackChunkName: "claim-modal-seller" */ './components/Pages/Tickets/components/ClaimModalSeller.vue').default);
Vue.component( 'bank-account-modal', require(/* webpackChunkName: "bank-account-modal" */ './components/Pages/Tickets/components/BankAccountModal.vue').default);

Vue.component( 'home-search', require(/* webpackChunkName: "home-search" */ './components/Pages/Welcome/HomeSearch.vue').default);
Vue.component( 'recent-tickets', require(/* webpackChunkName: "recent-tickets" */ './components/Pages/Welcome/RecentTickets.vue').default);
Vue.component( 'home-buyer-seller-info', require(/* webpackChunkName: "home-buyer-seller-info" */ './components/Pages/Welcome/BuyerSellerInfo.vue').default);
Vue.component( 'my-alerts', require(/* webpackChunkName: "my-alerts" */ './components/Pages/Alerts/Alerts.vue').default);


Vue.component( 'messages-home', require(/* webpackChunkName: "messages-home" */ './components/Pages/Message/Home.vue').default);
Vue.component( 'discussion', require(/* webpackChunkName: "discussion" */ './components/Pages/Message/Discussion.vue').default);

// Unique components (used in one place only)
Vue.component( 'change-password', require(/* webpackChunkName: "change-password" */ './components/Pages/Profile/ChangePassword.vue').default);
Vue.component( 'delete-account', require(/* webpackChunkName: "delete-account" */ './components/Pages/Profile/DeleteAccount.vue').default);





