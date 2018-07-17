
/**
 * Detect if in local environment or not
 */
var host = window.location.hostname;
var local = false;

if(host != 'lastar.io') {
    local = true;
}

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
window.Vue.use(require('vue-resource'));

/**
 * Add lodash to vue
 */
import lodash from 'lodash';
Object.defineProperty(Vue.prototype, '$lodash', { value: lodash });


/**
 * Use Sentry to report errors
 */

import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';
if (local) {
    Raven.config('https://55043330c18c47a29c0d04e79e9426be@sentry.io/305544')
        .addPlugin(RavenVue, Vue)
        .install();
}
/**
 * We use VeeValidator, and therefore need to set the language.
 */
import VeeValidate, { Validator }  from 'vee-validate';
import localeFr from './validator/fr.js';
import localeEn from './validator/en.js';
var lang = document.head.querySelector('meta[name="lang"]').content;

if (lang === 'fr') {
    window.Vue.use(VeeValidate, {
        locale: 'fr',
        dictionary: {
            fr: localeFr,
        }
    });
} else {
    Validator.localize('ar', localeEn);
    window.Vue.use(VeeValidate)
}

window.locale = lang;

/**
 * We use the front-end framework elem-io, and therefore need to set the language.
 */


import ElementUI from 'element-ui';
import langEn from 'element-ui/lib/locale/lang/en';
import langFr from 'element-ui/lib/locale/lang/fr';
import locale from 'element-ui/lib/locale';

if (lang === 'fr') {
    locale.use(langFr)
} else {
    locale.use(langEn)
}

window.Vue.use(ElementUI);

/**
 * We use moment.js to handle date on the front-end, we set language here
 */

var moment = require('moment');

if (lang === 'fr') {
    moment.locale('fr');
} else {
    moment.locale('en');
}

window.moment = moment;


/**
 *
 * Laravel Echo
 *
 */

import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

let pusherKey = document.head.querySelector('meta[name="pusher:app_key"]').content;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: pusherKey,
    cluster: 'eu',
    encrypted: true
});

/**
 * We'll load the vue HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

let token = document.head.querySelector('meta[name="csrf-token"]').content;
window.csrf = token;

if (token) {
    window.Vue.http.interceptors.push(function (request, next) {
        // modify headers
        request.headers.set('X-Socket-ID', window.Echo.socketId());
        request.headers.set('X-CSRF-TOKEN', token);
        request.headers.set('Content-Type', 'application/json');
        request.headers.set('Accept', 'application/json');

        request.credentials = true;
        // continue to next interceptor
        next();
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
