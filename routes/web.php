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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/test', function () {
    $eurostar = new \App\EurostarAPI\Eurostar();
    $date = $eurostar::create_date(7,2,2017);
    $trains = $eurostar->singles("Londres","Bruxelles",$date);
    return response()->json($trains);
});


