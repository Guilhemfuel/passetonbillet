<?php

namespace App\Console\Commands;

use App\EurostarAPI\Eurostar;
use Illuminate\Console\Command;

class UpdateTrains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trains:update';

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

        $eurostar = new Eurostar();

        $trains = [];
        $my_date = date("Y-m-d", strtotime("tomorrow"));

        //Display information to terminal
        $this->info('Retrieving data from Eurostar API');
        $bar = $this->output->createProgressBar(count($eurostar->connections)*2);

        //Loop through all possible journey combination to retrive all trains
        foreach ($eurostar->connections as $connection){

            $temp_trains = $eurostar->singles($connection[0],$connection[1],$my_date);
            $trains = array_merge($trains,$temp_trains);
            $bar->advance();
            $temp_trains = $eurostar->singles($connection[1],$connection[0],$my_date);
            $trains = array_merge($trains,$temp_trains);
            $bar->advance();

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

        //TODO: retrieve for 2-3 month | Everyday 1 day?


    }
}
