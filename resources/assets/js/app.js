
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
Vue.component('phone', require('./components/Phone.vue'));
Vue.component('timepicker', require('./components/Timepicker.vue'));
Vue.component('stationpicker', require('./components/Stationpicker.vue'));
Vue.component('userpicker', require('./components/Userpicker.vue'));




/**
 *
 * Common JS to all pages
 *
 */

