<?php

namespace App\Console\Commands;

use App\Scopes\ScamFilteredScope;
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
        ini_set( 'memory_limit', '1G' );

        // Scammers
        $scammers = User::where( 'status', User::STATUS_BANNED_USER )->get();
        $this->line( count( $scammers ) . ' scammers found.' );
        $this->getUserStats( $scammers );

        $this->getMoreDetailsScammers( $scammers );

        $ticketsScam = Ticket::withTrashed()->whereIn( 'user_id', $scammers->pluck( 'id' ) )
                             ->with( 'discussions.messages' )->get();
        $this->line( count( $ticketsScam ) . ' scam tickets.' );
        $this->getTicketsStats( $ticketsScam );

        // Region details about scammers


        // Regulat
        $regularTickets = Ticket::withTrashed()->whereNotIn( 'user_id', $scammers->pluck( 'id' ) )
                                ->with( 'discussions.messages' )->get();


        $regularUsers = User::where( 'status', User::STATUS_USER )->get();
        $this->line( "\n\n" );
        $this->line( count( $regularUsers ) . ' regular users.' );
        $this->getUserStats( $regularUsers );
        $this->line( count( $regularTickets ) . ' regular tickets.' );
        $this->getTicketsStats( $regularTickets );

    }

    public function getUserStats( $users )
    {
        $fb = 0;
        $id = 0;

        foreach ( $users as $user ) {
            if ( $user->fb_id ) {
                $fb ++;
            }

            if ( $user->id_verified ) {
                $id ++;
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
            foreach ( $ticket->discussions as $discussion ) {
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
        foreach ( $prodivder as $key => $value ) {
            $this->line( $value * 100 / count( $tickets ) . ' % of ticket with provider ' . $key );
        }

        // Show other results
        $this->line( array_sum( $messagesCount ) / count( $messagesCount ) . ' messages per ticket on average' );
        $this->line( array_sum( $discussions ) / count( $discussions ) . ' discussions per ticket on average' );
    }

    public function getMoreDetailsScammers( $scammers )
    {
        $info = [
            'id_verified'         => 0,
            'id_type'             => [],
            'id_country'          => [],
            'phone_country'       => [],
            'ticket_count'        => [],
            'days_before_publish' => []
        ];
        foreach ( $scammers as $scammer ) {
            $info['id_verified'] += $scammer->id_verified ? 1 : 0;
            $info['id_type'][] = $scammer->id_verified ? ($scammer->idVerification->type?:'-') : '-';
            $info['id_country'][] = $scammer->id_verified ? ($scammer->idVerification->country?:'-') : '-';
            $info['phone_country'][] = $scammer->phone_country?: '-';
            $info['ticket_count'][] = $scammer->tickets()->withoutGlobalScope( ScamFilteredScope::class )->withTrashed()->count();

            $firstTicketDate = $scammer->tickets()->withoutGlobalScope( ScamFilteredScope::class )->withTrashed()->orderBy( 'created_at' )->first();
            if ( ! $firstTicketDate ) {
                $this->warn( 'First ticket not found.' );
            } else {
                $info['days_before_publish'][] = $firstTicketDate->created_at->diff( $scammer->created_at )->days;
            }
        }

        $this->line( 'Users with id verified: ' . $info['id_verified'] . '/' . count( $scammers ) );
        $info['id_type'] = array_count_values( $info['id_type'] );
        $info['id_country'] = array_count_values( $info['id_country'] );
        $info['phone_country'] = array_count_values( $info['phone_country'] );

        foreach ( [ 'id_type', 'id_country', 'phone_country' ] as $key ) {
            $this->line( 'Decomposition of ' . count( $scammers ) . ' users for property:' . $key );
            foreach ( $info[ $key ] as $key => $value ) {
                $this->line( "\t${key} : ${value}" );
            }
        }

        $this->line( array_sum( $info['ticket_count'] ) / count( $info['ticket_count'] ) . ' tickets published on average' );
        $this->line( array_sum( $info['days_before_publish'] ) / count( $info['days_before_publish'] ) . ' days before publishing first ticket' );
    }
}
