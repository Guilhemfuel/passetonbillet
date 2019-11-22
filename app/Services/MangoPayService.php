<?php

namespace App\Services;

use App\Transaction;
use MangoPay;

class MangoPayService
{
    private $mangoPayApi;
    private $mangoUser;

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

    private function calculateFees($amount) {
        return (Transaction::FEES / 100) * $amount;
    }

    public function createMangoUser($user) {

        try {
            $mangoUser = new MangoPay\UserNatural();
            $mangoUser->PersonType = "NATURAL";
            $mangoUser->FirstName = $user->first_name;
            $mangoUser->LastName = $user->last_name;
            $mangoUser->Birthday = strtotime($user->birthdate);
            $mangoUser->Nationality = $user->idVerification ? $user->idVerification->country : "FR";
            $mangoUser->CountryOfResidence = $user->idVerification ? $user->idVerification->country : "FR";
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
            $cardRegistration->Currency = "EUR";
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
            $PayIn->DebitedFunds->Currency = "EUR";
            $PayIn->DebitedFunds->Amount = $data->Amount * 100;

            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency = "EUR";
            $PayIn->Fees->Amount = 0;
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

    public function createWallet($name, $currency) {
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

            $pagination = new MangoPay\Pagination();
            $pagination->Page = 1;
            $pagination->ItemsPerPage = 20;

            $filter = new MangoPay\FilterTransactions();

            $sorting = new MangoPay\Sorting();
            $sorting->AddField("CreationDate", MangoPay\SortDirection::DESC);

            $transactions = $this->mangoPayApi->Wallets->GetTransactions($id, $pagination, $filter, $sorting);
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

    public function createBankAccount($data) {
        try {
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

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function getBankAccount($user = null) {
        try {

            if(!$user) {
                $user = $this->mangoUser;
            }

            $pagination = new MangoPay\Pagination();
            $pagination->Page = 1;
            $pagination->ItemsPerPage = 5;

            $sorting = new MangoPay\Sorting();
            $sorting->AddField("CreationDate", MangoPay\SortDirection::DESC);

            $BankAccount = $this->mangoPayApi->Users->GetBankAccounts($user, $pagination, $sorting);
            return $BankAccount ? $BankAccount[0] : null;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function listRefundsPayIn($PayInId) {
        try {

            $Refunds = $this->mangoPayApi->PayIns->Get($PayInId);
            return $Refunds;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function createRefundPayIn($PayInId, $user, $amount = null, $split = null) {
        try {
            $Refund = new MangoPay\Refund();
            $Refund->AuthorId = $user;

            //If there is no amount then the full amount is refund
            if($amount) {
                $amount = $split ? ($amount / 2) : $amount;

                $Refund->DebitedFunds = new MangoPay\Money();
                $Refund->DebitedFunds->Currency = "EUR";
                $Refund->DebitedFunds->Amount = $amount;

                $Refund->Fees = new MangoPay\Money();
                $Refund->Fees->Currency = "EUR";
                $Refund->Fees->Amount = $this->calculateFees($amount);
            }

            $Refund = $this->mangoPayApi->PayIns->CreateRefund($PayInId, $Refund);

            return $Refund;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function getRefund($id) {
        try {

            $Refund = $this->mangoPayApi->Refunds->Get($id);
            return $Refund;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function createPayOut($bankAccount, $user, $wallet) {
        try {
            $PayOut = new MangoPay\PayOut();
            $PayOut->AuthorId = $user;
            $PayOut->DebitedWalletID = $wallet->Id;

            $PayOut->DebitedFunds = new MangoPay\Money();
            $PayOut->DebitedFunds->Currency = "EUR";
            $PayOut->DebitedFunds->Amount = $wallet->Balance->Amount;

            $PayOut->Fees = new MangoPay\Money();
            $PayOut->Fees->Currency = "EUR";
            $PayOut->Fees->Amount = $this->calculateFees($wallet->Balance->Amount);

            $PayOut->PaymentType = "BANK_WIRE";
            $PayOut->MeanOfPaymentDetails = new MangoPay\PayOutPaymentDetailsBankWire();
            $PayOut->MeanOfPaymentDetails->BankAccountId = $bankAccount->Id;

            $PayOut = $this->mangoPayApi->PayOuts->Create($PayOut);

            return $PayOut;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function getPayOut($id) {
        try {

            $Refund = $this->mangoPayApi->PayOuts->Get($id);
            return $Refund;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function createKycDocument($user) {
        try {

            $KycDocument = new \MangoPay\KycDocument();
            $KycDocument->Type = "IDENTITY_PROOF";

            $KycDocument = $this->mangoPayApi->Users->CreateKycDocument($user, $KycDocument);

            return $KycDocument;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function createKycPage($user, $kycDocument, $fileUrl) {
        try {

            $KycPage = new MangoPay\KycPage();
            $KycPage->File = base64_encode(file_get_contents($fileUrl));

            if (empty($KycPage->File)) {
                throw new \MangoPay\Libraries\Exception('Content of the file cannot be empty');
            }

            return $Kyc = $this->mangoPayApi->Users->CreateKycPage($user, $kycDocument, $KycPage, null);

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function submitKycDocument($user, $kycDocoument) {
        try {

            $KycDocument = new MangoPay\KycDocument();
            $KycDocument->Id = $kycDocoument;
            $KycDocument->Status = "VALIDATION_ASKED";

            $KycDocument = $this->mangoPayApi->Users->UpdateKycDocument($user, $KycDocument);
            return $KycDocument;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }

    public function viewKycDocument($user, $kycDocument) {
        try {

            $KycDocument = $this->mangoPayApi->Users->GetKycDocument($user, $kycDocument);
            return $KycDocument;

        } catch (MangoPay\Libraries\ResponseException $e) {
            return $e->GetMessage();
        } catch (MangoPay\Libraries\Exception $e) {
            return $e->GetMessage();
        }
    }
}