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

// Robot.txt
Route::get('/robots.txt','RobotController@index');

Route::redirect('/html', '/', 301);
Route::redirect('/revendre-billet-train', '/', 301);
Route::redirect('/html/revendre-billet-train', '/', 301);

// Home Page
Route::get( '/', 'PageController@home' )->name( 'home' );

Route::get( '/home', function(){
    return redirect()->route('home');
})->name( 'home-redirect' );

// Lang
Route::get( 'lang/lang-{locale}.js', 'LanguageController@getLangJsFile' )->name( 'lang.js' );
Route::get( 'lang/{lang}', 'LanguageController@switchLang' )->name( 'lang' );

/**
 * Auth - login, register routes
 **/
Route::get( 'register', 'Auth\RegisterController@showRegistrationForm' )->name( 'register.page' );
Route::post( 'register', 'Auth\RegisterController@register' )->name( 'register' );
Route::get( '/verify-email/{token}', 'Auth\RegisterController@verify' )->name( 'register.verify-email' );

// Login & logout
Route::get( 'login', 'Auth\LoginController@showLoginForm' )->name( 'login.page' );
Route::post( 'login', 'Auth\LoginController@login' )->name( 'login' );
Route::get( 'logout', 'Auth\LoginController@logout' )->name( 'logout' );

// Password Routes...
Route::get( 'password/reset/', 'Auth\ForgotPasswordController@showLinkRequestForm' )->name( 'password.email_page' );
Route::get( 'password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm' )->name( 'password.reset.page' );
Route::post( 'password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail' )->name( 'password.post_email' );
Route::post( 'password/reset', 'Auth\ResetPasswordController@reset' )->name( 'password.reset.post_new_password' );

//// Register Social
Route::get( '/register/fb', 'Auth\RegisterController@fb_redirect' )->name( 'fb.connect' );
Route::get( '/register/fb/callback', 'Auth\RegisterController@fb_callback' )->name( 'fb.callback' );
Route::post( '/register/fb/confirm', 'Auth\RegisterController@fb_confirm_inscription' )->name( 'fb.confirm' );

/**
 * Condtions, privacy, contact...
 **/
// Conditions
Route::get('/cgu','PageController@cgu')->name('cgu.page');
Route::get('/privacy','PageController@privacy')->name('privacy.page');

// About page
Route::get('/about','PageController@about')->name('about.page');

// Contact page
Route::get( '/contact', 'PageController@contact' )->name( 'contact.page' );
Route::post( '/contact', 'HelpController@contact' )->name( 'contact' );

// Ticket search page
Route::get( 'ticket/buy', 'PageController@buyPage' )->name( 'public.ticket.buy.page' );

// Auth Routes
Route::group( [ 'middleware' => 'auth', 'as' => 'public.' ], function () {

    /**
     * Ticket routes
     **/

    Route::group( [ 'prefix' => 'ticket', 'as' => 'ticket.' ], function () {

        // Sell ticket
        Route::get( 'sell', 'PageController@sellPage' )->name( 'sell.page' );
        Route::post( 'sell', 'TicketController@sellTicket' )->name( 'sell.post' )->middleware( 'auth.verified.phone' );
        Route::post( 'manual_sell', 'TicketController@sellManualTicket' )->name( 'sell.manual' )->middleware( 'auth.verified.phone' );


        // See my tickets
        // Possible values for tab: selling (default), sold, offered, bought
        Route::get( 'owned/{tab?}', 'PageController@myTicketsPage' )->name( 'owned.page' );

        // Remove a non-sold ticket
        Route::delete( '/', 'TicketController@delete' )->name( 'delete' );

        // Download ticket
        Route::get( 'download/{ticket_id}', 'TicketController@downloadTicket' )->name( 'download' );

    } );

    /**
     * Messages routes
     **/
    Route::group( [ 'prefix' => 'messages', 'as' => 'message.' ], function () {

        Route::get( '/', 'PageController@messagePage' )->name( 'home.page' );
        Route::post( '/deny', 'DiscussionController@denyOffer' )->name( 'offer.deny' );
        Route::post( '/accept', 'DiscussionController@acceptOffer' )->name( 'offer.accept' );
        // Sow conversation oage
        Route::get( '/{ticket_id}/{discussion_id}', 'DiscussionController@getDiscussion' )->name( 'discussion.page' );

        // Confirm sell to this user
        Route::post( '/{ticket_id}/{discussion_id}/sell', 'DiscussionController@sell' )->name( 'discussion.sell' );

    } );

    /**
     * Profile routes
     **/
    Route::group( [ 'prefix' => 'profile', 'as' => 'profile.' ], function () {

        Route::get( '/user/{user_id}', 'PageController@profileStranger' )->name( 'stanger' );
        Route::get( '/', 'PageController@profile' )->name( 'home' );

        Route::post( 'phone/add', 'UserController@addPhone' )->name( 'phone.add' );
        Route::post( 'phone/verify', 'UserController@verifyPhone' )->name( 'phone.verify' );
        Route::post( 'password/change', 'UserController@changePassword' )->name( 'password.change' );
        Route::post( 'picture/upload', 'UserController@changeProfilePicture' )->name( 'picture.upload' );
        Route::post( 'identity/upload', 'UserController@uploadId' )->name( 'id.upload' );

    } );

} );

/**
 *
 * Ticket unique - Register for guests, offer for members
 *
 */

Route::group( [ 'prefix' => 'ticket', 'as' => 'ticket.' ], function () {
    Route::get( '/{ticket_id}', 'PageController@ticketUnique' )->name( 'unique.page' );
} );


/**
 * Admin routes
 **/
Route::blacklist(function() {
    Route::group( [ 'prefix' => 'ptbadmin', 'middleware' => 'auth.admin' ], function () {
        Route::get( '/', 'Admin\HomeController@home' )->name( 'admin.home' );

        Route::resource( 'users', 'Admin\UserController' );
        Route::group( [ 'prefix' => 'users' ], function () {
            Route::get( '/impersonate/{id}', 'Admin\UserController@impersonate' )->name( 'users.impersonate' );
            Route::get( '/ban/{id}', 'Admin\UserController@banUser' )->name( 'users.ban' );
        } );

        Route::resource( 'tickets', 'Admin\TicketController' );
        Route::group( [ 'prefix' => 'tickets', 'as' => 'tickets.' ], function () {
            Route::get( '/redownload/{ticket_id}', 'Admin\TicketController@redownload' )->name( 'redownload' );
            Route::get( '/scam/{ticket_id}', 'Admin\TicketController@markAsFraud' )->name( 'scam' );
            Route::post( '/manual-upload/{ticket_id}', 'Admin\TicketController@pdfManualUpload' )->name( 'manual_upload' );
        } );

        Route::resource( 'stations', 'Admin\StationController' );
        Route::resource( 'trains', 'Admin\TrainController' );

        Route::resource( 'offers', 'Admin\DiscussionController' );
        Route::group( [ 'prefix' => 'offers', 'as' => 'offers.' ], function () {
            Route::get( '/undeny/{id}', 'Admin\DiscussionController@cancelDeny' )->name( 'undeny' );
        } );


        Route::group( [ 'prefix' => 'id_check' ], function () {
            Route::get( '/', 'Admin\UserController@getOldestIdCheck' )->name( 'id_check.oldest' );
            Route::post( '/confirm', 'Admin\UserController@acceptIdVerification' )->name( 'id_check.accept' );
            Route::post( '/deny', 'Admin\UserController@denyIdVerification' )->name( 'id_check.deny' );
        } );

        Route::group( [ 'prefix' => 'stats' ], function () {
            Route::get( '/', 'Admin\StatsController@index' )->name( 'stats.index' );
        } );

        Route::group( [ 'prefix' => 'logs' ], function () {
            Route::get( '/', 'Admin\HomeController@logs' )->name( 'logs.index' );
        } );

    } );
});


/**
 *
 *   Api routes
 *
 **/
Route::group( [ 'prefix' => 'api' ], function () {
    Route::get( 'tickets/buy', 'TicketController@buyTickets' )->name( 'api.tickets.buy' );
    Route::get( 'stations/search', 'StationController@stationSearch' )->name( 'api.stations.search' );
    Route::get( 'stations/{id}', 'StationController@show' )->name( 'api.stations.show' );


    Route::group( [ 'middleware' => 'auth.admin' ], function () {
        Route::get( 'users/{name}', 'Admin\UserController@searchAPI' )->name( 'api.users.search' );
    } );

    Route::group( [ 'middleware' => 'auth' ], function () {
        Route::get( 'notifications', 'UserController@getNotifications' )->name( 'api.notifications' );
        Route::post( 'ticket/search', 'TicketController@searchTickets' )->name( 'api.tickets.search' );
        Route::post( 'ticket/offer', 'TicketController@makeAnOffer' )->name( 'api.tickets.offer' );

        // Discussion api routes
        Route::post( 'messages/{ticket}/{discussion}', 'DiscussionController@sendMessage' )->name( 'api.discussion.send' );
        Route::post( 'messages/{ticket}/{discussion}/read', 'DiscussionController@markAsRead' )->name( 'api.discussion.read' );

        // Reviews
        Route::post( 'reviews', 'API\ReviewController@store' )->name( 'api.reviews.store' );

    } );
} );


