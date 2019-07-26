<?php

namespace App\Console\Commands;

use App\Ticket;
use App\User;
use Illuminate\Console\Command;

class DataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:data-metrics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Output some basic data stats on user behaviours.';

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
        ini_set('memory_limit', '1G');

        // Scammers
        $scammers = User::where( 'status', User::STATUS_BANNED_USER )->get();
        $this->line( count( $scammers ) . ' scammers found.' );
        $this->getUserStats($scammers);

        $ticketsScam = Ticket::withTrashed()->whereIn( 'user_id', $scammers->pluck( 'id' ) )
                             ->with( 'discussions.messages' )->get();
        $this->line( count( $ticketsScam ) . ' scam tickets.' );
        $this->getTicketsStats( $ticketsScam );

        // Regulat
        $regularTickets = Ticket::withTrashed()->whereNotIn( 'user_id', $scammers->pluck( 'id' ) )
                                ->with( 'discussions.messages' )->get();


        $regularUsers = User::where( 'status', User::STATUS_USER )->get();
        $this->line("\n\n");
        $this->line(count($regularUsers).' regular users.');
        $this->getUserStats($regularUsers);
        $this->line( count( $regularTickets ) . ' regular tickets.' );
        $this->getTicketsStats( $regularTickets );

    }

    public function getUserStats( $users )
    {
        $fb = 0;
        $id = 0;

        foreach ($users as $user) {
            if ($user->fb_id) {
                $fb++;
            }

            if ($user->id_verified) {
                $id++;
            }
        }

        $this->line( $fb * 100 / count( $users ) . ' % users with fb connect.' );
        $this->line( $id * 100 / count( $users ) . ' % users with id verified.' );

    }

    public function getTicketsStats( $tickets )
    {
        $discussions = [];
        $messagesCount = [];
        $prodivder = [];

        foreach ( $tickets as $ticket ) {
            $discussions[] = $ticket->discussions()->count();

            // Messsage stats
            $msgCount = 0;
            foreach ($ticket->discussions as $discussion) {
                $msgCount += $discussion->messages->count();
            }

            $messagesCount[] = $msgCount;

            // Provider stats
            if ( isset( $prodivder[ $ticket->provider ] ) ) {
                $prodivder[ $ticket->provider ] ++;
            } else {
                $prodivder[ $ticket->provider ] = 1;
            }
        }

        // Show providers info
        foreach ($prodivder as $key=>$value ) {
            $this->line($value * 100/count($tickets) . ' % of ticket with provider '. $key);
        }

        // Show other results
        $this->line( array_sum( $messagesCount )  / count( $messagesCount ) . ' messages per ticket on average' );
        $this->line( array_sum( $discussions ) / count( $discussions ) . ' discussions per ticket on average' );
    }
}
