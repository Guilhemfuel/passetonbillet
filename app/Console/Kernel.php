<?php

namespace App\Console;

use App\Console\Commands\FlushCache;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateTrains::class,
        Commands\Empower::class,
        Commands\AnonymiseData::class,
        Commands\DownloadAllMissingTicketPdfs::class,
        Commands\CleanEmails::class,
        Commands\CleanTickets::class,
        Commands\CleanAll::class,
        Commands\DeleteAdminWarnings::class,
        Commands\GenerateSitemap::class,
        Commands\GenerateLanguage::class,
        Commands\DailyStats::class,
        Commands\DataCommand::class,
        Commands\OutputEmails::class,
        Commands\IdAutomation::class,
        Commands\AcceptIds::class
    ];

    /**
     * Define the application's command schedule.
     *
     * To start the scheduler you must call:
     * * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('telescope:prune')->daily();
        $schedule->command('ptb:generate-sitemap')->daily();
        $schedule->command('ptb:daily-stats')->daily();
        $schedule->command('ptb:accept-ids')->hourly();

        $schedule->command(Commands\CleanAll::class)
                 ->dailyAt('3:00')
                 ->sendOutputTo(storage_path() . '/logs/clean.log');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
