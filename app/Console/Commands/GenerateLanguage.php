<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateLanguage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:generate-language';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create language files.';

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
        $locales = array_keys(config('app.locales'));

        foreach ($locales as $locale) {


            $files   = glob(resource_path('lang/' . $locale . '/*.php'));
            $strings = [];

            foreach ($files as $file) {
                $name           = basename($file, '.php');
                $strings[$name] = require $file;
            }

            file_put_contents(resource_path("assets/js/lang/lang-${locale}.js"),'window.i18n = ' . json_encode($strings,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES). ';');

            $this->line("Locale ${locale} file created.");

        }

       $this->line("Done. ". count($locales) .' locale files created.');
    }

}
