<?php

namespace App\Console\Commands;

use App\Models\AdminWarning;
use Illuminate\Console\Command;

class DeleteAdminWarnings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:delete-admin-warnings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all admin warnings.';

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
        AdminWarning::truncate();
        $this->line('Done.');
    }
}
