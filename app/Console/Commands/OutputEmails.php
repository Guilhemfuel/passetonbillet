<?php

namespace App\Console\Commands;

use App\Mail\AcceptedOfferEmail;
use App\Mail\AlertEmail;
use App\Mail\ContactEmail;
use App\Mail\EmailVerification;
use App\Mail\MailResetPassword;
use App\Mail\MessageEmail;
use App\Mail\OfferEmail;
use App\Mail\PtbMail;
use App\Mail\ReviewRequestEmail;
use App\Mail\TicketSoldEmail;
use App\Mail\Verification\IdConfirmedMail;
use App\Mail\Verification\IdDeniedMail;
use App\Mail\WelcomeEmail;
use App\Models\Alert;
use App\Train;
use App\Models\Discussion;
use App\User;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Notifications\AnonymousNotifiable;

class OutputEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:output-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Output all emails in storage path to see them.';

    protected $faker;

    /**
     *
     * Note: all methods starting with 'renderEmail' are automatically called.
     *
     * So to add a new email simply create a new private methods starting with 'renderEmail';
     *
     */

    const RENDER_METHOD_STARTS_WITH = 'renderEmail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->faker = Factory::create();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = storage_path( 'emails/' );

        // Check if folder exist or create it
        if ( ! file_exists( $path ) ) {
            mkdir( $path, 0777, true );
        }


        // Render each email
        $methods = get_class_methods( self::class );
        $count = 0;
        foreach ( $methods as $method ) {
            if ( substr( $method, 0, strlen( self::RENDER_METHOD_STARTS_WITH ) ) === self::RENDER_METHOD_STARTS_WITH ) {
                $this->saveEmailFromMethod( $path, $method );
                $count ++;
            }
        }


        $this->line( 'Done. ' . $count . ' emails rendered.' );
    }

    /**
     * Given a methode name, save emails in differnet locales.
     *
     * @param $method
     */
    private function saveEmailFromMethod( $path, $method )
    {
        $locales = array_keys( config( 'app.locales' ) );

        $email = $this->{$method}();

        foreach ( $locales as $locale ) {
            if ( $email instanceof PtbMail ) {
                $email->forceLocale( $locale );
            } else {
                file_put_contents( $path . substr( $method, strlen( self::RENDER_METHOD_STARTS_WITH ) ) . '.html', $email->render() );
                break;
            }

            file_put_contents( $path . $locale . '_' . substr( $method, strlen( self::RENDER_METHOD_STARTS_WITH ) ) . '.html', $email->render() );

        }
    }

    /**
     * Below are all the individual email functions
     */

    private function renderEmailIdConfirmed()
    {
        $user = User::first();
        $email = new IdConfirmedMail( $user );

        return $email;
    }

    private function renderEmailIdDenied()
    {
        $user = User::first();
        $email = new IdDeniedMail( $user, $this->faker->sentence );

        return $email;
    }

    private function renderEmailAcceptedOffer()
    {
        $discussion = Discussion::where( 'status', '!=', - 1 )->first();
        $email = new AcceptedOfferEmail( $discussion->buyer, $discussion );

        return $email;
    }

    private function renderEmailAlertWithUser()
    {
        $alert = Alert::latest()->first();
        $user = User::first();
        $train = Train::latest()->first();
        $email = new AlertEmail( $alert, $train, $user );

        return $email;
    }

    private function renderEmailAlertWithoutUser()
    {
        $alert = Alert::latest()->first();
        $train = Train::latest()->first();
        $email = new AlertEmail( $alert, $train, ( new AnonymousNotifiable() )->route( 'mail', $this->faker->email ) );

        return $email;
    }

    private function renderEmailContact()
    {
        $email = new ContactEmail( $this->faker->name, $this->faker->email, $this->faker->text );

        return $email;
    }

    private function renderEmailVerificationEmail()
    {
        $user = User::first();

        $email = new EmailVerification( $user );

        return $email;
    }

    private function renderEmailMailReset()
    {
        $user = User::first();

        $email = new MailResetPassword( $user, $this->faker->word );

        return $email;
    }

    private function renderEmailMessageReceived()
    {
        $discussion = Discussion::where( 'status', '!=', - 1 )->first();
        $email = new MessageEmail( $discussion->buyer, $discussion->ticket, $discussion );

        return $email;
    }

    private function renderEmailOfferReceived()
    {
        $discussion = Discussion::where( 'status', '!=', - 1 )->first();
        $email = new OfferEmail( $discussion->buyer, $discussion->ticket );

        return $email;
    }

    private function renderEmailReviewRequest()
    {
        $discussion = Discussion::where( 'status', '!=', - 1 )->first();
        $email = new ReviewRequestEmail( $discussion->buyer, $discussion );

        return $email;
    }

    private function renderEmailTicketSold()
    {
        $discussion = Discussion::where( 'status', '!=', - 1 )->first();
        $email = new TicketSoldEmail( $discussion->buyer, $discussion );

        return $email;
    }

    private function renderEmailWelcome()
    {
        $discussion = Discussion::where( 'status', '!=', - 1 )->first();
        $email = new WelcomeEmail( $discussion->buyer );

        return $email;
    }


}
