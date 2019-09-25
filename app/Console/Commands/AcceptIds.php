<?php

namespace App\Console\Commands;

use App\Models\Verification\IdVerification;
use Illuminate\Console\Command;

class AcceptIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:accept-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Accept all pending ids.';

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
        $ids = IdVerification::where( 'accepted', null )->get();

        $this->line(count($ids). " ids found.");

        foreach ($ids as $idVerif) {
            $idVerif->accepted = true;
            $idVerif->save();
        }

        $this->line('Done. All accepted.');
    }
}
