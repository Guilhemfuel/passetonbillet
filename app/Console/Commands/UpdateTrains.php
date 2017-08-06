<?php

namespace App\Console\Commands;


use App\Exceptions\LastarException;
use App\Facades\Eurostar;
use App\Station;
use Illuminate\Console\Command;

class UpdateTrains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lastar:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all trains in the database, and add the missing one (in the month) using the Eurostar API.';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Set timer to time cron job
        $start = microtime(true);

        $trains = [];
        $my_date = new \DateTime('tomorrow');

        //Display information to terminal
        $stations = Station::all();
        $this->info("Retrieving data from Eurostar API");
        $bar = $this->output->createProgressBar(count($stations)*count($stations));

        //Loop through all possible journey combination to retrieve all trains
        foreach ($stations as $departure_station){
            foreach ($stations as $arrival_station) {
                // Retry 3 times in case of error
                for ($i=1; $i <= 3; $i++) {
                    try {
                        $temp_trains = Eurostar::singles( $departure_station, $arrival_station, $my_date );
                        $trains = array_merge( $trains, $temp_trains );
                        break;
                    }
                    catch (LastarException $e) {
                        $this->alert($departure_station->name_en.' to '.$arrival_station->name_en.' error.');
                    }
                }
                $bar->advance();
            }
        }

        //Display information to terminal
        $this->info("\nCreating or updating trains.");
        $bar = $this->output->createProgressBar(count($trains));

        //Create or update trains
        $created = 0;
        $updated = 0;
        foreach ($trains as $train){
            $existing_train = \App\Train::where('departure_date',$train->departure_date)
                ->where('number',$train->number)
                ->where('departure_city',$train->departure_city)
                ->where('arrival_city',$train->arrival_city)
                ->first();

            if ($existing_train === null){
                //If doesn't exist create it
                $train->save();
                $created++;
            } else{
                //If it does exist, update possible time changes
                $existing_train = $train;
                $existing_train->save();
                $updated++;
            }
            $bar->advance();
        }

        $this->info("\nExecution time: ".(microtime(true) - $start)." sec. ".$created." entries created and ".$updated." entries updated.");

    }
}
