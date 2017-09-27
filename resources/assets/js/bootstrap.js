
window._ = require('lodash');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue');
window.Vue.use(require('vue-resource'));

/**
 * We use VeeValidator, and therefore need to set the language.
 */
import VeeValidate from 'vee-validate';
import localeFr from './validator/fr.js';
let lang = document.head.querySelector('meta[name="lang"]');

if (lang.content === 'fr') {
    console.log('ok');
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
 * We'll load the vue HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.Vue.http.interceptors.push(function (request, next) {
        // modify headers
        request.headers.set('X-CSRF-TOKEN', token.content);
        request.credentials = true;
        // continue to next interceptor
        next();
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}