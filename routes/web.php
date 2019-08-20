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
Route::get( '/robots.txt', 'RobotController@index' )->name('robot');

Route::redirect( '/html/{any}', '/', 301 );
Route::redirect( '/revendre-billet-train', '/', 301 );

// Home Page
Route::get( '/', 'PageController@home' )->name( 'home' );

Route::get( '/home', 'PageController@homeRedirect' )->name( 'home-redirect' );

// Lang
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
 * Public ticket pages
 */

// Sell ticket, this will return to different pages, depending on whether you are logged in
Route::get( 'ticket/sell', 'PageController@sellPage' )->name( 'public.ticket.sell.page' );

// Ticket search page
Route::get( 'ticket/buy', 'PageController@buyPage' )->name( 'public.ticket.buy.page' );

/**
 * WebHooks
 */

//Route::get('/fb/webhook','Chatbot\MessengerController@verifyWebhook')->name('fb.chatbot.webhook.verify');

/**
 * Condtions, privacy, contact...
 **/
// Conditions
Route::get( '/cgu', 'PageController@cgu' )->name( 'cgu.page' );
Route::get( '/privacy', 'PageController@privacy' )->name( 'privacy.page' );

// About page
Route::get( '/about', 'PageController@about' )->name( 'about.page' );

// Help Page
Route::get( '/help', 'PageController@help' )->name( 'help.page' );

// Contact page
Route::get( '/contact', 'PageController@contact' )->name( 'contact.page' );
Route::post( '/contact', 'HelpController@contact' )->name( 'contact' );

/**
 * Connected user routes (auth middleware)
 */
Route::group( [ 'middleware' => 'auth', 'as' => 'public.' ], function () {

    /**
     * Ticket routes
     **/

    Route::group( [ 'prefix' => 'ticket', 'as' => 'ticket.' ], function () {


        Route::post( 'sell', 'TicketController@sellTicket' )->name( 'sell.post' )->middleware( 'auth.verified.phone' );
        Route::post( 'edit/{ticket_id}', 'TicketController@changeTicketPrice' )->name( 'edit' )->middleware( 'auth.verified.phone' );

        // See my tickets
        // Possible values for tab: selling (default), sold, offered, bought
        Route::get( 'owned/{tab?}', 'PageController@myTicketsPage' )->name( 'owned.page' );

        // Remove a non-sold ticket
        Route::delete( '/', 'TicketController@deleteOrSell' )->name( 'delete_or_sell' );

        // Download ticket
        Route::get( 'download/{ticket_id}', 'TicketController@downloadTicket' )->name( 'download' );

    } );

    /**
     * Alerts routes
     */
    Route::get( '/alerts', 'PageController@alertsPage' )->name( 'alerts.page' );

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

        Route::get( '/user/{user_id}/', 'PageController@profileStranger' )->name( 'stanger' );
        Route::get( '/', 'PageController@profile' )->name( 'home' );

        Route::post( 'phone/add', 'UserController@addPhone' )->name( 'phone.add' );
        Route::post( 'phone/verify', 'UserController@verifyPhone' )->name( 'phone.verify' );
        Route::post( 'password/change', 'UserController@changePassword' )->name( 'password.change' );
        Route::post( 'picture/upload', 'UserController@changeProfilePicture' )->name( 'picture.upload' );
        Route::post( 'identity/upload', 'UserController@uploadId' )->name( 'id.upload' );
        Route::delete( 'delete-account', 'UserController@deleteAccount' )->name( 'delete-account' );
    } );

} );

/**
 *
 * Ticket unique - Register for guests, offer for members
 *
 */

Route::group( [ 'prefix' => 'ticket', 'as' => 'ticket.' ], function () {
    Route::get( '/{ticket_id}', 'PageController@ticketUnique' )->name( 'unique.page' );
    Route::get( '/{ticket_id}/{departure}/{arrival}', 'PageController@ticketUnique' )->name( 'unique.station_slug.page' );

} );

/**
 *
 * Ticket unique - Register for guests, offer for members
 *
 */

Route::group( [ 'prefix' => 'img', 'as' => 'image.' ], function () {
    Route::get( '/ticket/{ticket_id}.png', 'PageController@ticketPreview' )->name( 'ticket.preview' );
} );


/**
 * Admin routes
 **/
Route::blacklist( function () {
    Route::group( [ 'prefix' => 'ptbadmin', 'middleware' => 'auth.admin' ], function () {
        Route::get( '/', 'Admin\HomeController@home' )->name( 'admin.home' );

        Route::resource( 'users', 'Admin\UserController' );
        Route::group( [ 'prefix' => 'users' ], function () {
            Route::get( '/verify/{id}', 'Admin\UserController@verifyUser' )->name( 'users.verify' );
            Route::get( '/impersonate/{id}', 'Admin\UserController@impersonate' )->name( 'users.impersonate' );
            Route::get( '/ban/{id}', 'Admin\UserController@banUser' )->name( 'users.ban' );
        } );

        Route::resource( 'tickets', 'Admin\TicketController' );
        Route::group( [ 'prefix' => 'tickets', 'as' => 'tickets.' ], function () {
            Route::get( '/redownload/{ticket_id}', 'Admin\TicketController@redownload' )->name( 'redownload' );
            Route::get( '/scam/{ticket_id}', 'Admin\TicketController@markAsFraud' )->name( 'scam' );
            Route::get( '/{ticket_id}/restore', 'Admin\TicketController@restore' )->name( 'restore' );
            Route::post( '/manual-upload/{ticket_id}', 'Admin\TicketController@pdfManualUpload' )->name( 'manual_upload' );
            Route::put( '/revert-status/{ticket_id}', 'Admin\TicketController@revertStatus' )->name( 'revert_status' );
        } );

        Route::resource( 'trains', 'Admin\TrainController' );
        Route::resource( 'help_questions', 'Admin\HelpQuestionController' );


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

        Route::group( [ 'prefix' => 'reviews' ], function () {
            Route::get( '/', 'Admin\HomeController@reviews' )->name( 'reviews.index' );
        } );

        Route::group( [ 'prefix' => 'warnings' ], function () {
            Route::get( '/', 'Admin\WarningController@index' )->name( 'warnings.index' );
            Route::get( '/done/{warning}', 'Admin\WarningController@markAsDone' )->name( 'warnings.mark_as_done' );
        } );
    } );
} );


/**
 *
 *   Api routes
 *
 **/
Route::group( [ 'prefix' => 'api' ], function () {
    Route::post( 'alerts/create', 'API\AlertController@createAlert' )->name( 'api.alerts.create' );
    Route::delete( '/alerts/{alert_id}', 'API\AlertController@deleteAlert' )->name( 'api.alerts.delete' );


    Route::get( 'tickets/buy', 'TicketController@buyTickets' )->name( 'api.tickets.buy' );
    Route::get( 'tickets/affiliates/sncf', 'API\AffiliateController@sncfAffiliate' )->name( 'api.tickets.affiliates.sncf' );
    Route::get( 'stations/search', 'StationController@stationSearch' )->name( 'api.stations.search' );
    Route::get( 'stations/{id}', 'StationController@show' )->name( 'api.stations.show' );
    Route::get( 'tickets/{ticket}/phone-number/{country}', 'API\TicketController@getPaidPhoneNumber' )->name( 'api.tickets.phone_number' );


    /**
     * Admin API
     */
    Route::group( [ 'middleware' => 'auth.admin' ], function () {
        Route::get( 'users/{name}', 'Admin\UserController@searchAPI' )->name( 'api.users.search' );
    } );

    /**
     * Auth API using middleware auth
     */
    Route::group( [ 'middleware' => 'auth' ], function () {
        Route::get( 'notifications', 'UserController@getNotifications' )->name( 'api.notifications' );

        // Ticket api routes
        Route::post( 'ticket/search', 'TicketController@searchTickets' )->name( 'api.tickets.search' );
        Route::post( 'ticket/offer', 'TicketController@makeAnOffer' )->name( 'api.tickets.offer' );
        Route::get( 'ticket/{ticket}/offers/', 'API\TicketController@getOffers' )->name( 'api.tickets.offers' );

        // Discussion api routes
        Route::post( 'messages/{ticket}/{discussion}', 'DiscussionController@sendMessage' )->name( 'api.discussion.send' );
        Route::post( 'messages/{ticket}/{discussion}/read', 'DiscussionController@markAsRead' )->name( 'api.discussion.read' );

        // Reviews
        Route::post( 'reviews', 'API\ReviewController@store' )->name( 'api.reviews.store' );

    } );
} );


