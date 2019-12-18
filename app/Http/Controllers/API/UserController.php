<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MangoPayService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Get all credit cards from User in Mangopay
    public function getCards() {

        $this->middleware('auth');

        $user = \Auth::user();
        $mangoPay = new MangoPayService();

        //Create Mango User if not exist
        if (!$user->mangopay_id) {

            try {
                $mangoUser = $mangoPay->createMangoUser($user);
            } catch (\MangoPay\Libraries\ResponseException $e) {
                return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
            } catch (\MangoPay\Libraries\Exception $e) {
                return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
            }

            $user->mangopay_id = $mangoUser->Id;
            $user->save();
        }

        try {
            $cards = $mangoPay->getAllCards($user->mangopay_id);
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        } catch (\MangoPay\Libraries\Exception $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        }

        return response()->json($cards);
    }

    //This method will return a secure form for Mangopay to add new credit card
    public function addCardRegistration(Request $request) {

        $this->middleware('auth');

        $user = \Auth::user();

        $mangoPay = new MangoPayService();

        try {
            $mangoPay->getMangoUser($user->mangopay_id);
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        } catch (\MangoPay\Libraries\Exception $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        }

        try {
            $cardRegistration = $mangoPay->createCardRegistration($request->data);
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        } catch (\MangoPay\Libraries\Exception $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        }

        return response()->json($cardRegistration);
    }

    //This method will save the new Credit card from the custom form in addCardRegistration
    public function updateCardRegistration(Request $request) {

        $this->middleware('auth');

        $mangoPay = new MangoPayService();

        try {
            $result = $mangoPay->updateCardRegistration($request->id, $request->data);
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        } catch (\MangoPay\Libraries\Exception $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        }

        return response()->json($result);
    }

    public function getBankAccount() {
        $this->middleware('auth');

        $user = \Auth::user();
        $mangoPay = new MangoPayService();

        try {
            $mangoPay->getMangoUser($user->mangopay_id);
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        } catch (\MangoPay\Libraries\Exception $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        }

        try {
            $bankAccount = $mangoPay->getBankAccount();
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        } catch (\MangoPay\Libraries\Exception $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        }

        return response()->json(['bankAccount' => $bankAccount]);
    }

    public function updateBankAccount(Request $request) {
        $this->middleware('auth');

        $user = \Auth::user();
        $mangoPay = new MangoPayService();

        try {
            $mangoPay->getMangoUser($user->mangopay_id);
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        } catch (\MangoPay\Libraries\Exception $e) {
            return response()->json(['message' => __( 'tickets.mangopay_error'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
        }

        if($request->iban && $request->nameAccount && $request->address && $request->city && $request->postal) {

            try {
                $bankAccount = $mangoPay->createBankAccount($request);
            } catch (\MangoPay\Libraries\ResponseException $e) {
                return response()->json(['message' => __( 'tickets.bank_account_not_valid'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
            } catch (\MangoPay\Libraries\Exception $e) {
                return response()->json(['message' => __( 'tickets.bank_account_not_valid'), 'type' => 'error', 'mangopay' => $e->GetMessage()], 400);
            }

            if(isset($bankAccount->UserId)) {
                return response()->json(['message' => __( 'tickets.bank_account_success'), 'type' => 'success', 'bankAccount' => $bankAccount]);
            }

            return response()->json(['message' => __( 'tickets.bank_account_not_valid'), 'type' => 'error', 'bankAccount' => $bankAccount]);
        }

        return response()->json(['message' => __( 'tickets.bank_account_not_complete'), 'type' => 'error']);
    }
}
