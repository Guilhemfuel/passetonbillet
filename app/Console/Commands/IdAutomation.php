<?php

namespace App\Console\Commands;

use App\Models\Verification\IdVerification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class IdAutomation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:id-automation {limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Work on automating the id reading';

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

        $path = storage_path( 'ids/' );

        // Check if folder exist or create it
        if ( ! file_exists( $path ) ) {
            mkdir( $path, 0777, true );
        }

        $date = Carbon::now()->format( 'dmy' );
        $path = $path . $date . '/';
        // Create directory format
        if ( ! file_exists( $path ) ) {
            mkdir( $path, 0777, true );
        }

        // Retrieve ids
        $ids = IdVerification::where( 'accepted', true )
                             ->orderBy( 'created_at', 'desc' )
                             ->limit( (int) $this->argument( 'limit' ) )
                             ->get();

        $bar = $this->output->createProgressBar((int) $this->argument( 'limit' ) );

        $meta = [];
        foreach ( $ids as $id ) {
            $scanUrl = $id->getAttributes()['scan'];
            if (!\Storage::disk( 's3' )->exists( $scanUrl )) {
                $this->warn("Skipping one, missing file.");
                continue;
            }

            $fileId = \Storage::disk( 's3' )->get( $scanUrl );

            file_put_contents( $path . substr( $scanUrl, strlen('id_verification/') ), $fileId );
            $meta[] = [
                'file'          => $scanUrl,
                'first_name'    => $id->user->first_name,
                'last_name'     => $id->user->last_name,
                'birthdate'     => $id->user->birthdate->format('d/m/y'),
                'document_type' => $id->type,
                'country'       => $id->country
            ];

            $bar->advance();
        }
        $bar->finish();

        // Finally store meta
        file_put_contents( $path . 'meta-infos.json', json_encode($meta) );
        $this->line('Done.');
    }
}
