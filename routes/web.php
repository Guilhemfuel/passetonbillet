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
Route::get( '/testRetrieve', function(){
    Debugbar::info(\App\Facades\Eurostar::retrieveTicket('nahum','RTXYUS'));

    return view('dummy');
} )->name( 'test.billet' );

// Auth Routes
Route::group( [ 'middleware' => 'auth', 'as'=>'public.' ], function () {

    // Ticket routes
    Route::group( [ 'prefix' => 'ticket', 'as' => 'ticket.' ], function () {

        // Sell ticket
        Route::get('sell','PageController@sellPage')->name('sell.page');
        Route::post('sell','TicketController@sellTicket')->name('sell.post')->middleware('auth.verified.phone');

        // See my tickets
        Route::get('owned','PageController@myTicketsPage')->name('owned.page');

        // Buy a ticket
        Route::get('buy','PageController@buyPage')->name('buy.page');

    } );

    // Messages routes
    Route::group( [ 'prefix' => 'message', 'as' => 'message.' ], function () {

        Route::get('/','PageController@messagePage')->name('home.page');

    } );

    // Profile routes
    Route::group( [ 'prefix' => 'profile', 'as' => 'profile.' ], function () {

        Route::get('/','PageController@profile')->name('home');

        Route::post('phone/add','UserController@addPhone')->name('phone.add');
        Route::post('phone/verify','UserController@verifyPhone')->name('phone.verify');
        Route::post('password/change','UserController@changePassword')->name('password.change');
        Route::post('picture/upload','UserController@changeProfilePicture')->name('picture.upload');
        Route::post('identity/upload','UserController@uploadId')->name('id.upload');

    } );

} );

// Admin Routes...
Route::group( [ 'prefix' => 'lastadmin', 'middleware' => 'auth.admin' ], function () {
    Route::get( '/', 'Admin\HomeController@home' )->name( 'admin.home' );

    Route::resource( 'users', 'Admin\UserController' );
    Route::resource( 'tickets', 'Admin\TicketController' );
    Route::resource( 'stations', 'Admin\StationController' );
    Route::resource( 'trains', 'Admin\TrainController' );

    Route::group( [ 'prefix' => 'id_check' ], function () {
        Route::get( '/', 'Admin\UserController@getOldestIdCheck' )->name( 'id_check.oldest' );
        Route::post( '/confirm', 'Admin\UserController@acceptIdVerification' )->name( 'id_check.accept' );
        Route::post( '/deny', 'Admin\UserController@denyIdVerification' )->name( 'id_check.deny' );

    } );

});

// API routes...
Route::group( [ 'prefix' => 'api' ], function () {
    Route::group( [ 'middleware' => 'auth.admin' ], function () {
        Route::get( 'users/{name}', 'Admin\UserController@searchAPI' )->name( 'api.users.search' );
    } );

    Route::group( [ 'middleware' => 'auth' ], function () {
        Route::get( 'stations', 'StationController@stations' )->name( 'api.stations.list' );
        Route::get('notifications','UserController@getNotifications')->name('api.notifications');
        Route::post('ticket/search','TicketController@searchTickets')->name('api.tickets.search');
        Route::post('ticket/offer','TicketController@makeAnOffer')->name('api.tickets.offer');
    } );

    Route::post('tickets/buy','TicketController@buyTickets')->name('api.tickets.buy');
} );
