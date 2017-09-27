
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

import '../css/element-lastar/index.css';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en';

Vue.use(ElementUI, { locale });
Vue.component('cleave', require('vue-cleave'));
Vue.component('vue-select', require('vue-select'));
Vue.component('datepicker', require('vuejs-datepicker'));

// Inputs
Vue.component('phone', require('./components/Inputs/Phone.vue'));
Vue.component('timepicker', require('./components/Inputs/Timepicker.vue'));
Vue.component('stationpicker', require('./components/Inputs/Stationpicker.vue'));
Vue.component('userpicker', require('./components/Inputs/Userpicker.vue'));

// Shared
Vue.component('modal', require('./components/Shared/Modal.vue'));

// Pages
Vue.component('auth', require('./components/Pages/Auth.vue'));

