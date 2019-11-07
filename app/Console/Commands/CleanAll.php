<?php

namespace App\Console\Commands;

use App\Models\EmailSent;
use Illuminate\Console\Command;

class CleanAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:clean-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calls ptb:clean-emails and ptb:clean-tickets internally';

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
        $this->call('ptb:clean-emails');
        $this->line('');
        $this->call('ptb:clean-tickets');

        // TODO: clean past notifications (1 month), telescope tables, stats and admin warnings
    }
}
