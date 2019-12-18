<?php

namespace App\Services;

use App\Transaction;
use MangoPay;

class MangoPayService
{
    private $mangoPayApi;
    private $mangoUser;

    CONST EUR_CURRENCY = "EUR";

    public function __construct()
    {
        $storagePath = storage_path('mangopay');
        if(!file_exists($storagePath) && !is_dir($storagePath)) {

            mkdir($storagePath, 0777, true);
        }

        $this->mangoPayApi = new MangoPay\MangoPayApi();
        $this->mangoPayApi->Config->ClientId = env('MANGOPAY_ID');
        $this->mangoPayApi->Config->ClientPassword = env('MANGOPAY_PASSWORD');
        $this->mangoPayApi->Config->BaseUrl = env('MANGOPAY_URL');
        $this->mangoPayApi->Config->TemporaryFolder = $storagePath;
    }

    private function calculateFees($fees, $amount) {
        return ($fees / 100) * $amount;
    }

    public function createMangoUser($user)
    {
        $mangoUser = new MangoPay\UserNatural();
        $mangoUser->PersonType = "NATURAL";
        $mangoUser->FirstName = $user->first_name;
        $mangoUser->LastName = $user->last_name;
        $mangoUser->Birthday = strtotime($user->birthdate);
        $mangoUser->Nationality = $user->nationality ? $user->nationality : "FR";
        $mangoUser->CountryOfResidence = $user->country_residence ? $user->country_residence : "FR";
        $mangoUser->Email = $user->email;

        $mangoUser = $this->mangoPayApi->Users->Create($mangoUser);

        $this->mangoUser = $mangoUser->Id;

        return $mangoUser;
    }

    public function getMangoUser($id)
    {
        $user = $this->mangoPayApi->Users->Get($id);
        $this->mangoUser = $user->Id;

        return $user;
    }

    public function getAllCards($id) {
        $cards = $this->mangoPayApi->Users->GetCards($id);
        return $cards;
    }

    public function createCardRegistration($card = null) {
        $cardRegistration = new MangoPay\CardRegistration();
        $cardRegistration->UserId = $this->mangoUser;
        $cardRegistration->Currency = self::EUR_CURRENCY;
        $cardRegistration->CardType = isset($card->type) ? $card->type : "CB_VISA_MASTERCARD";

        $cardRegistration = $this->mangoPayApi->CardRegistrations->Create($cardRegistration);

        return $cardRegistration;
    }

    public function updateCardRegistration($id, $data) {
            $cardRegistration = new MangoPay\CardRegistration();
            $cardRegistration->Id = $id;
            $cardRegistration->RegistrationData = $data;

            $cardRegistration = $this->mangoPayApi->CardRegistrations->Update($cardRegistration);

            return $cardRegistration;
    }

    public function directPayIn($data) {
        $PayIn = new MangoPay\PayIn();
        $PayIn->CreditedWalletId = $data->CreditedWalletId;
        $PayIn->AuthorId = $data->AuthorId;

        $PayIn->PaymentType = "CARD";
        $PayIn->PaymentDetails = new MangoPay\PayInPaymentDetailsCard();

        $PayIn->DebitedFunds = new \MangoPay\Money();
        $PayIn->DebitedFunds->Currency = self::EUR_CURRENCY;
        $PayIn->DebitedFunds->Amount = $data->Amount * 100;

        $PayIn->Fees = new \MangoPay\Money();
        $PayIn->Fees->Currency = self::EUR_CURRENCY;
        $PayIn->Fees->Amount = 0;
        $PayIn->ExecutionType = "DIRECT";

        $PayIn->ExecutionDetails = new MangoPay\PayInExecutionDetailsDirect();
        $PayIn->ExecutionDetails->SecureModeReturnURL = $data->SecureModeReturnURL;
        $PayIn->ExecutionDetails->CardId = $data->CardId;

        $PayIn = $this->mangoPayApi->PayIns->Create($PayIn);

        return $PayIn;
    }

    public function createWallet($name, $currency) {
        $wallet = new MangoPay\Wallet();
        $wallet->Owners = array($this->mangoUser);
        $wallet->Description = "Passe Ton Billet - Ticket : " . $name;
        $wallet->Currency = self::EUR_CURRENCY;

        $wallet = $this->mangoPayApi->Wallets->Create($wallet);

        return $wallet;
    }

    public function getWallet($id) {
        $wallet = $this->mangoPayApi->Wallets->Get($id);
        return $wallet;
    }

    public function getAllWallet() {
        $wallets = $this->mangoPayApi->Users->GetWallets($this->mangoUser);
        return $wallets;
    }

    public function getWalletTransactions($id) {
        $pagination = new MangoPay\Pagination();
        $pagination->Page = 1;
        $pagination->ItemsPerPage = 20;

        $filter = new MangoPay\FilterTransactions();

        $sorting = new MangoPay\Sorting();
        $sorting->AddField("CreationDate", MangoPay\SortDirection::DESC);

        $transactions = $this->mangoPayApi->Wallets->GetTransactions($id, $pagination, $filter, $sorting);
        return $transactions;
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

    public function createBankAccount($data) {
        $BankAccount = new MangoPay\BankAccount();
        $BankAccount->Type = "IBAN";
        $BankAccount->Details = new MangoPay\BankAccountDetailsIBAN();
        $BankAccount->Details->IBAN = $data->iban;
        $BankAccount->OwnerName = $data->nameAccount;

        $BankAccount->OwnerAddress = new MangoPay\Address();
        $BankAccount->OwnerAddress->AddressLine1 = $data->address;
        $BankAccount->OwnerAddress->City = $data->city;
        $BankAccount->OwnerAddress->PostalCode = $data->postal;
        $BankAccount->OwnerAddress->Country = \Auth::user()->phone_country;

        $BankAccount = $this->mangoPayApi->Users->CreateBankAccount($this->mangoUser, $BankAccount);

        return $BankAccount;
    }

    public function getBankAccount($user = null) {
        if (!$user) {
            $user = $this->mangoUser;
        }

        $pagination = new MangoPay\Pagination();
        $pagination->Page = 1;
        $pagination->ItemsPerPage = 5;

        $sorting = new MangoPay\Sorting();
        $sorting->AddField("CreationDate", MangoPay\SortDirection::DESC);

        $BankAccount = $this->mangoPayApi->Users->GetBankAccounts($user, $pagination, $sorting);
        return $BankAccount ? $BankAccount[0] : null;
    }

    public function listRefundsPayIn($PayInId) {
        $Refunds = $this->mangoPayApi->PayIns->Get($PayInId);
        return $Refunds;
    }

    public function createRefundPayIn($PayInId, $user, $fees = null, $amount = null, $split = null) {
        $Refund = new MangoPay\Refund();
        $Refund->AuthorId = $user;

        //If there is no amount then the full amount is refund
        if ($amount) {
            $amount = $split ? ($amount / 2) : $amount;

            $Refund->DebitedFunds = new MangoPay\Money();
            $Refund->DebitedFunds->Currency = self::EUR_CURRENCY;
            $Refund->DebitedFunds->Amount = $amount;

            $Refund->Fees = new MangoPay\Money();
            $Refund->Fees->Currency = self::EUR_CURRENCY;
            $Refund->Fees->Amount = $this->calculateFees($fees, $amount);
        }

        $Refund = $this->mangoPayApi->PayIns->CreateRefund($PayInId, $Refund);

        return $Refund;
    }

    public function getRefund($id) {
        $Refund = $this->mangoPayApi->Refunds->Get($id);
        return $Refund;
    }

    public function createPayOut($bankAccount, $user, $wallet, $fees, $amount) {
        $PayOut = new MangoPay\PayOut();
        $PayOut->AuthorId = $user;
        $PayOut->DebitedWalletID = $wallet->Id;

        $PayOut->DebitedFunds = new MangoPay\Money();
        $PayOut->DebitedFunds->Currency = self::EUR_CURRENCY;
        $PayOut->DebitedFunds->Amount = $wallet->Balance->Amount;

        $PayOut->Fees = new MangoPay\Money();
        $PayOut->Fees->Currency = self::EUR_CURRENCY;
        $PayOut->Fees->Amount = $this->calculateFees($fees, $amount);

        $PayOut->PaymentType = "BANK_WIRE";
        $PayOut->MeanOfPaymentDetails = new MangoPay\PayOutPaymentDetailsBankWire();
        $PayOut->MeanOfPaymentDetails->BankAccountId = $bankAccount->Id;

        $PayOut = $this->mangoPayApi->PayOuts->Create($PayOut);

        return $PayOut;
    }

    public function getPayOut($id) {
        $Refund = $this->mangoPayApi->PayOuts->Get($id);
        return $Refund;
    }

    public function createKycDocument($user) {
        $KycDocument = new \MangoPay\KycDocument();
        $KycDocument->Type = "IDENTITY_PROOF";

        $KycDocument = $this->mangoPayApi->Users->CreateKycDocument($user, $KycDocument);

        return $KycDocument;
    }

    public function createKycPage($user, $kycDocument, $fileUrl) {
        $KycPage = new MangoPay\KycPage();
        $KycPage->File = base64_encode(file_get_contents($fileUrl));

        if (empty($KycPage->File)) {
            throw new \MangoPay\Libraries\Exception('Content of the file cannot be empty');
        }

        return $Kyc = $this->mangoPayApi->Users->CreateKycPage($user, $kycDocument, $KycPage, null);
    }

    public function submitKycDocument($user, $kycDocoument) {
        $KycDocument = new MangoPay\KycDocument();
        $KycDocument->Id = $kycDocoument;
        $KycDocument->Status = "VALIDATION_ASKED";

        $KycDocument = $this->mangoPayApi->Users->UpdateKycDocument($user, $KycDocument);
        return $KycDocument;
    }

    public function viewKycDocument($user, $kycDocument) {
        $KycDocument = $this->mangoPayApi->Users->GetKycDocument($user, $kycDocument);
        return $KycDocument;
    }
}