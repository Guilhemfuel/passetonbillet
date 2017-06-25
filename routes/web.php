<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Page
Route::get('/', 'PageController@home')->name('home');

// Lang
Route::get('lang/{lang}', 'LanguageController@switchLang')->name('lang');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register.page');
Route::post('register', 'Auth\RegisterController@register')->name('register');
// Auth Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login.page');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// Password Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm')->name('password.token');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail')->name('password.email');
Route::post('password/reset', 'Auth\PasswordController@reset')->name('password.page');

// Register Social
Route::get('/redirect/fb', 'Auth\RegisterController@fb_redirect')->name('fb_redirect');
Route::get('/callback/fb', 'Auth\RegisterController@fb_callback')->name('fb_callback');

// Test ticket
Route::get('/test', 'TicketController@test')->name('test.billet');

// Auth Routes...
Route::group(['middleware' => 'auth'], function()
{
    Route::get('/auth', function () {
        return 'ok';
    });
});

// Admin Routes...
Route::group(['prefix' => 'lastadmin',  'middleware' => 'auth.admin'], function()
{

});
