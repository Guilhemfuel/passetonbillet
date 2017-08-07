
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
 */

Vue.component('datepicker', require('vuejs-datepicker'));
Vue.component('cleave', require('vue-cleave'));


/**
 *
 * Common JS to all pages
 *
 */

// Phone formatter
require('cleave.js/src/addons/phone-type-formatter.fr');
require('cleave.js/src/addons/phone-type-formatter.gb');
require('cleave.js/src/addons/phone-type-formatter.be');

const swal = require('sweetalert2')


$( document ).ready(function() {

    $swal = swal;

    // Navbar mobile logo color change
    $('#nav').click(function(){
        $toggler = $('#nav').find("#toggle-nav");
        if($toggler.attr('aria-expanded') === "false"){
            $('#nav').find('.navbar-brand').addClass('mobile');
        } else {
            $('#nav').find('.navbar-brand').removeClass('mobile');
        }
    });

});
