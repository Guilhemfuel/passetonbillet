<?php

namespace App\Console\Commands;

use App\Ticket;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * Contains route name and the associated priority
     *
     * @var array
     */
    protected $routeNames = [
        ['home',1],
        ['public.ticket.sell.page',0.9],
        ['public.ticket.buy.page',0.9],
        ['register.page',0.9],
        ['login.page',0.9],
        ['cgu.page',0.6],
        ['privacy.page',0.6],
        ['about.page',0.6],
        ['help.page',0.6],
        ['robot',0.6]
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate PTB sitemap.';

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
        $sitemap = Sitemap::create();
        foreach ($this->routeNames as $route) {
            $sitemap->add( Url::create(route($route[0]))
                              ->setPriority($route[1]))
                    ;
        }

        $this->addTicketsToSitemap($sitemap);

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->line('File "sitemap.xml" published in public directory.');
    }

    /**
     * Add all tickets url to a sitemap.
     */
    private function addTicketsToSitemap(Sitemap $sitemap) {

        $tickets = Ticket::with('train')->get();
        foreach ($tickets as $ticket) {
            $train = $ticket->train;
            $sitemap->add( Url::create(route('ticket.unique.station_slug.page',[
                $ticket->hash_id,
                $train->departureCity->slug,
                $train->arrivalCity->slug
            ]))->setPriority(0.4)
                ->setLastModificationDate($ticket->created_at)

            );
        }

    }
}
