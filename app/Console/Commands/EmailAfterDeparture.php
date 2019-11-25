<?php

namespace App\Console\Commands;

use App\Claim;
use App\Mail\SendAfterDepartureEmail;
use App\Services\MangoPayService;
use App\Ticket;
use App\Train;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EmailAfterDeparture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:make-email-after-departure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send email to Purchaser 1 hour after a departure train.';

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
        $dateToday = Carbon::now()->format('Y-m-d');
        $dateYesterday = Carbon::yesterday()->format('Y-m-d');

        //Get every train bought were departure is today or yesterday
        //Because if train departure is more than 23h00, email will be sent the next day
        $tickets = Ticket::select('*', 'transactions.id AS transaction_id')
            ->join('transactions', 'transactions.ticket_id', '=', 'tickets.id')
            ->where('transactions.status', 'SUCCEEDED')
            ->where('transactions.email_departure', null)
            ->join('trains', 'tickets.train_id', '=', 'trains.id')
            ->where('departure_date', $dateToday)
            ->orWhere('departure_date', $dateYesterday)
            ->get();

        $dateNow =Carbon::now();

        foreach($tickets as $ticket) {
            //If time for email is reached
            if($dateNow > $ticket->train->carbon_date_email_after_departure) {
                //If email has not been sent yet
                if(!$ticket->email_departure) {
                    $transaction = Transaction::where('id', $ticket->transaction_id)->first();
                    //Send Email to Purchaser
                    \Mail::to($transaction->purchaser->email)->send(new SendAfterDepartureEmail($transaction->purchaser, $transaction->ticket));

                    //Update status email after send
                    $transaction->email_departure = true;
                    $transaction->save();
                }
            }
        }

        dump('Done !');
    }
}