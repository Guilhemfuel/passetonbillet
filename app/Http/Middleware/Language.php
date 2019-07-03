<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If preferences already set
        if (Session::has('applocale') AND array_key_exists(Session::get('applocale'), config('app.locales'))) {
            App::setLocale(Session::get('applocale'));
        } else {
            $languages = $this->getBrowserLanguages();

            foreach ($languages as $language => $priority) {
                if (array_key_exists($language, config('app.locales'))) {
                    App::setLocale($language);
                    return $next($request);
                }
            }

            // If no prefered language was found, fallback
            App::setLocale(config('app.fallback_locale'));
        }
        return $next($request);
    }

    /**
     * Return array of browser languages, sorted by priority
     */
    private function getBrowserLanguages() {

        // Parse the Accept-Language according to:
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
        preg_match_all(
            '/([a-z]{1,8})' .       // M1 - First part of language e.g en
            '(-[a-z]{1,8})*\s*' .   // M2 -other parts of language e.g -us
            // Optional quality factor M3 ;q=, M4 - Quality Factor
            '(;\s*q\s*=\s*((1(\.0{0,3}))|(0(\.[0-9]{0,3}))))?/i',
            \request()->server('HTTP_ACCEPT_LANGUAGE'),
            $langParse);

        $langs = $langParse[1]; // M1 - First part of language
        $quals = $langParse[4]; // M4 - Quality Factor

        $numLanguages = count($langs);
        $langArr = array();

        for ($num = 0; $num < $numLanguages; $num++)
        {
            $newLang = strtolower($langs[$num]);
            $newQual = isset($quals[$num]) ?
                (empty($quals[$num]) ? 1.0 : floatval($quals[$num])) : 0.0;

            // Choose whether to upgrade or set the quality factor for the
            // primary language.
            $langArr[$newLang] = (isset($langArr[$newLang])) ?
                max($langArr[$newLang], $newQual) : $newQual;
        }

        // sort list based on value
        // langArr will now be an array like: array('EN' => 1, 'ES' => 0.5)
        arsort($langArr, SORT_NUMERIC);

        return $langArr;
    }
}
