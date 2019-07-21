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

}
