<?php

namespace App\Services;

use MangoPay;

class MangoPayService
{
    private $mangoPayApi;
    private $mangoUser;

    public function __construct()
    {
        $storagePath = storage_path('mangopay');
        if(!file_exists($storagePath) && !is_dir($storagePath)) {

            mkdir($storagePath, 0775, true);
        }

        $this->mangoPayApi = new MangoPay\MangoPayApi();
        $this->mangoPayApi->Config->ClientId = env('MANGOPAY_ID');
        $this->mangoPayApi->Config->ClientPassword = env('MANGOPAY_PASSWORD');
        $this->mangoPayApi->Config->BaseUrl = env('MANGOPAY_URL');
        $this->mangoPayApi->Config->TemporaryFolder = $storagePath;
    }

    public function createMangoUser($user) {

        try {
            $mangoUser = new MangoPay\UserNatural();
            $mangoUser->PersonType = "NATURAL";
            $mangoUser->FirstName = $user->first_name;
            $mangoUser->LastName = $user->last_name;
            $mangoUser->Birthday = strtotime($user->birthdate);
            $mangoUser->Nationality = $user->location ? $user->location : "FR";
            $mangoUser->CountryOfResidence = $user->location ? $user->location : "FR";
            $mangoUser->Email = $user->email;

            $mangoUser = $this->mangoPayApi->Users->Create($mangoUser);

            $this->mangoUser = $mangoUser->Id;

            return $mangoUser;

        } catch (MangoPay\Libraries\ResponseException $e) {
            // handle/log the response exception with code $e->GetCode(), message $e->GetMessage() and error(s) $e->GetErrorDetails()
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            // handle/log the exception $e->GetMessage()
            return $e->GetMessage();
        }
    }

    public function getMangoUser($id) {
        try {

            $user = $this->mangoPayApi->Users->Get($id);
            $this->mangoUser = $user->Id;

            return $user;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function createCardRegistration($card = null) {
        try {
            $cardRegistration = new MangoPay\CardRegistration();
            $cardRegistration->UserId = $this->mangoUser;
            $cardRegistration->Currency = isset($card->currency) ? $card->currency : "EUR";
            $cardRegistration->CardType = isset($card->type) ? $card->type : "CB_VISA_MASTERCARD";

            $cardRegistration = $this->mangoPayApi->CardRegistrations->Create($cardRegistration);

            return $cardRegistration;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function updateCardRegistration($id, $data) {
        try {

            $cardRegistration = new MangoPay\CardRegistration();
            $cardRegistration->Id = $id;
            $cardRegistration->RegistrationData = $data;

            $cardRegistration = $this->mangoPayApi->CardRegistrations->Update($cardRegistration);

            return $cardRegistration;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }
}