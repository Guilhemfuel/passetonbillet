<?php

namespace App\Http\Controllers\Chatbot;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessengerController extends Controller
{

    CONST HUB_VERIFY_TOKEN = 'ptbrocks';

    public function verifyWebhook( Request $request )
    {
        $this->validate( $request, [
            'hub_verify_token' => 'required',
            'hub_challenge'    => 'required',
            'hub_mode'         => 'required'
        ] );

        if ($request->hub_mode == "subscribe" && $request->hub_verify_token === self::HUB_VERIFY_TOKEN) {
            return response($request->get('hub_challenge'));
        }

        return response("Invalid token!", 400);
    }
}
