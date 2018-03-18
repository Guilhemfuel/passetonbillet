
window._ = require('lodash');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
window.Vue.use(require('vue-resource'));

/**
 * Use Sentry to report errors
 */

import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';
Raven.config('https://55043330c18c47a29c0d04e79e9426be@sentry.io/305544')
    .addPlugin(RavenVue, Vue)
    .install();

console.log(process.env.APP_ENV);

/**
 * We use VeeValidator, and therefore need to set the language.
 */
import VeeValidate from 'vee-validate';
import localeFr from './validator/fr.js';
var lang = document.head.querySelector('meta[name="lang"]').content;

if (lang === 'fr') {
    window.Vue.use(VeeValidate, {
        locale: 'fr',
        dictionary: {
            fr: localeFr,
        }
    });
} else {
    window.Vue.use(VeeValidate);
}

/**
 * We use the front-end framework elem-io, and therefore need to set the language.
 */


import ElementUI from 'element-ui';
import langEn from 'element-ui/lib/locale/lang/en';
import langFr from 'element-ui/lib/locale/lang/fr';
import locale from 'element-ui/lib/locale';

import '../sass/element-variables.scss'

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
 * We'll load the vue HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.Vue.http.interceptors.push(function (request, next) {
        // modify headers
        request.headers.set('X-CSRF-TOKEN', token.content);
        request.headers.set('Content-Type', 'application/json');
        request.headers.set('Accept', 'application/json');

        request.credentials = true;
        // continue to next interceptor
        next();
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}