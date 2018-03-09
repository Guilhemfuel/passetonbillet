<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Make sure a user can contact us via the form
     */
    public function contact( Request $request )
    {
        $this->validate( $request, [
            'g-recaptcha-response' => 'required|captcha',
            'name'                 => 'required',
            'email'                => 'required|email',
            'message'              => 'required'
        ] );

        dd($request->getContent());
    }
}
