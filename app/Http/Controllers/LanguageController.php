<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (array_key_exists($lang, config('app.locales'))) {
            Session::put('applocale', $lang);

            $user = \Auth::user();
            if($user) {
                $user->language = strtoupper($lang);
                $user->save();
            }
        }
        return back();
    }

    public function getLangJsFile($locale)
    {
        if (!array_key_exists($locale, config('app.locales'))) {
            $locale = config('app.fallback_locale');
        }

        // Empty cache in local
        if (\App::environment() == 'local'){
            \Cache::forget("lang-{$locale}.js");
        }


        $strings = \Cache::rememberForever("lang-{$locale}.js", function () use ($locale) {

            $files   = glob(resource_path('lang/' . $locale . '/*.php'));
            $strings = [];

            foreach ($files as $file) {
                $name           = basename($file, '.php');
                $strings[$name] = require $file;
            }

            return $strings;
        });

        header('Content-Type: text/javascript');
        echo('window.i18n = ' . json_encode($strings) . ';');
        exit();
    }
}
