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

    public function getAllCards($id) {
        try {

            $cards = $this->mangoPayApi->Users->GetCards($id);
            return $cards;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetCode();
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

    public function directPayIn($data) {
        try {

            $PayIn = new MangoPay\PayIn();
            $PayIn->CreditedWalletId = $data->CreditedWalletId;
            $PayIn->AuthorId = $data->AuthorId;

            $PayIn->PaymentType = "CARD";
            $PayIn->PaymentDetails = new MangoPay\PayInPaymentDetailsCard();

            $PayIn->DebitedFunds = new \MangoPay\Money();
            $PayIn->DebitedFunds->Currency = $data->Currency;
            $PayIn->DebitedFunds->Amount = $data->Amount * 100;

            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency = $data->CurrencyFees;
            $PayIn->Fees->Amount = $data->AmountFees * 100;
            $PayIn->ExecutionType = "DIRECT";

            $PayIn->ExecutionDetails = new MangoPay\PayInExecutionDetailsDirect();
            $PayIn->ExecutionDetails->SecureModeReturnURL = $data->SecureModeReturnURL;
            $PayIn->ExecutionDetails->CardId = $data->CardId;

            $PayIn = $this->mangoPayApi->PayIns->Create($PayIn);

            return $PayIn;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function createWallet($name) {
        try {

            $wallet = new MangoPay\Wallet();
            $wallet->Owners = array ($this->mangoUser);
            $wallet->Description = "Passe Ton Billet - Ticket : " . $name;
            $wallet->Currency = "EUR";

            $wallet = $this->mangoPayApi->Wallets->Create($wallet);

            return $wallet;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function getWallet($id) {
        try {

            $wallet = $this->mangoPayApi->Wallets->Get($id);
            return $wallet;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function getAllWallet() {
        try {

            $wallets = $this->mangoPayApi->Users->GetWallets($this->mangoUser);
            return $wallets;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function getWalletTransactions($id) {
        try {

            $transactions = $this->mangoPayApi->Wallets->GetTransactions($id);
            return $transactions;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function getTransaction($id, $wallet) {

        $transactions = $this->getWalletTransactions($wallet);

        foreach($transactions as $transaction) {
            if($transaction->Id === $id) {
                return $transaction;
            }
        }

        return null;
    }
}