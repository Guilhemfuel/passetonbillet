<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlushCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:flush-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush cache to regenerate lang files.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Cache::flush();
        $this->line('Cache flushed.');
    }
}
