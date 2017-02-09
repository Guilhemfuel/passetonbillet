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

    $start = microtime(true);

    $eurostar = new \App\EurostarAPI\Eurostar();

    $trains = [];
    $my_date = "2017-02-10";

    //Loop through all possible journey combination and add them to train
    foreach ($eurostar->connections as $connection){
        $temp_trains = $eurostar->singles($connection[0],$connection[1],$my_date);
        $trains = array_merge($trains,$temp_trains);
        $temp_trains = $eurostar->singles($connection[1],$connection[0],$my_date);
        $trains = array_merge($trains,$temp_trains);
    }


    //Create or update trains

    $created = 0;
    $updated = 0;
    foreach ($trains as $train){
        $existing_train = \App\Train::where('departure_date',$train->departure_date)
            ->where('number',$train->number)
            ->where('departure_city',$train->departure_city)
            ->where('arrival_city',$train->arrival_city)
            ->first();

        if ($train === null){
            //If doesn't exist create it
            $train->save();
            $created++;
        } else{
            //If it does exist, update possible time changes
            $existing_train = $train;
            $existing_train->save();
            $updated++;
        }
    }

    return "Execution time: ".(microtime(true) - $start).". ".$created." entries created and ".$updated." entries updated.";
});


