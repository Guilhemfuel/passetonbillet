<?php

namespace App\Console\Commands;

use App\Models\Statistic;
use App\Ticket;
use Illuminate\Console\Command;

class DailyStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:daily-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create daily stats in statistics table';

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
        \App\Facades\AppHelper::stat( Statistic::TICKET_COUNT_DAILY,[
            'tickets_count' => Ticket::count(),
            'current_tickets_count' => Ticket::currentTickets()->count()
        ]);
    }
}
