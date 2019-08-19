/**
 * Polyfill for IE
 */
import "@babel/polyfill";

if (typeof Object.assign != 'function') {
    Object.assign = function (target) {
        'use strict';
        if (target == null) {
            throw new TypeError('Cannot convert undefined or null to object');
        }

        target = Object(target);
        for (var index = 1; index < arguments.length; index++) {
            var source = arguments[index];
            if (source != null) {
                for (var key in source) {
                    if (Object.prototype.hasOwnProperty.call(source, key)) {
                        target[key] = source[key];
                    }
                }
            }
        }
        return target;
    };
}

/**
 * Detect if in local environment or not
 */
var host = window.location.hostname;
var local = false;

if (host != 'passetonbillet.fr') {
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
 * Use Sentry to report errors
 */

import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';

if (!local) {
    Raven.config('https://e9ebbd88548a441288393c457ec90441@sentry.io/3235', {
        environment: 'production'
    })
        .addPlugin(RavenVue, Vue)
        .install();
}
/**
 * We use VeeValidator, and therefore need to set the language.
 */
import VeeValidate, {Validator} from 'vee-validate';
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
require('moment/locale/fr');

if (lang === 'fr') {
    moment.locale('fr');
} else {
    moment.locale('en');
}

window.moment = moment;
window.Vue.prototype.$moment = moment;
window.Vue.prototype.route = route;
window.Vue.prototype.$mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

/**
 * Lodash
 */

window.Vue.prototype.$lodash = {
    'has': require('lodash/has'),
    'get': require('lodash/get'),
    'clone': require('lodash/clone'),
    'delay': require('lodash/delay'),
}

/**
 *
 * Language
 *
 */

window.Vue.prototype.trans = string => {
    return window.Vue.prototype.$lodash.get(window.i18n, string);
};


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
        request.headers.set('X-Socket-ID', window.Echo.socketId());
        request.headers.set('X-CSRF-TOKEN', token);
        request.headers.set('Content-Type', 'application/json');
        request.headers.set('Accept', 'application/json');

        next();
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Other metas
 */

window.nocaptcha_site_key = document.head.querySelector('meta[name="google:site_key"]').content;


/**
 * Other vue components
 */

import VueLazyload from 'vue-lazyload'
import Cleave from 'vue-cleave-component';

Vue.use(Cleave);
Vue.use(VueLazyload);

// To delete
let useless = 'ok';