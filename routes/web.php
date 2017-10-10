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
Route::get( '/', 'PageController@home' )->name( 'home' );

// Lang
Route::get( 'lang/{lang}', 'LanguageController@switchLang' )->name( 'lang' );

// Registration & Email verification
Route::get( 'register', 'Auth\RegisterController@showRegistrationForm' )->name( 'register.page' );
Route::post( 'register', 'Auth\RegisterController@register' )->name( 'register' );
Route::get('/verify-email/{token}', 'Auth\RegisterController@verify')->name('register.verify-email');

// Login & logout
Route::get( 'login', 'Auth\LoginController@showLoginForm' )->name( 'login.page' );
Route::post( 'login', 'Auth\LoginController@login' )->name( 'login' );
Route::get( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );

// Password Routes...
Route::get('password/reset/', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email_page');
Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.page');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.post_email');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.post_new_password');

//// Register Social
//Route::get( '/redirect/fb', 'Auth\RegisterController@fb_redirect' )->name( 'fb.connect' );
//Route::get( '/callback/fb', 'Auth\RegisterController@fb_callback' )->name( 'fb.callback' );

// Test ticket
Route::get( '/testRetrieve', 'TicketController@test' )->name( 'test.billet' );
Route::get( '/test', 'PageController@test' )->name( 'test.trains' );

// Auth Routes
Route::group( [ 'middleware' => 'auth', 'as'=>'public.' ], function () {

    // Ticket routes
    Route::group( [ 'prefix' => 'ticket', 'as' => 'ticket.' ], function () {

        Route::get('sell','PageController@sellPage')->name('sell.page');

    } );

} );

// Admin Routes...
Route::group( [ 'prefix' => 'lastadmin', 'middleware' => 'auth.admin' ], function () {
    Route::get( '/', 'Admin\HomeController@home' )->name( 'admin.home' );

    Route::resource('users', 'Admin\UserController');
    Route::resource('tickets', 'Admin\TicketController');
    Route::resource('stations', 'Admin\StationController');
    Route::resource('trains', 'Admin\TrainController');

} );

// API routes...
Route::group( [ 'prefix' => 'api' ], function () {
    Route::group( [ 'middleware' => 'auth.admin' ], function () {
        Route::get( 'stations', 'Admin\StationController@stations' )->name( 'api.stations.list' );
        Route::get( 'users/{name}', 'Admin\UserController@searchAPI' )->name( 'api.users.search' );
    } );

    Route::group( [ 'middleware' => 'auth' ], function () {
        Route::post('ticket/search','TicketController@searchTickets')->name('api.tickets.search');
    } );
} );
