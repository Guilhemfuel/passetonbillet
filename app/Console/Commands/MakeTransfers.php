<?php

namespace App\Console\Commands;

use App\Claim;
use App\Services\MangoPayService;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MakeTransfers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ptb:make-transfers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check every transaction to make transfer Mangopay';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Get all transactions not complete yet
        //It can be Payout failed or Refund failed or both
        $transactions = Transaction::select('*',
            'transactions.id AS id', 'claims.id AS claim_id',
            'transactions.status AS transaction_status', 'claims.status AS claim_status',
            'transactions.created_at AS transaction_created_at', 'claims.created_at AS claim_created_at')
            ->leftJoin('claims', 'claims.ticket_id', '=', 'transactions.ticket_id')
            ->where('transactions.status', 'SUCCEEDED')
            ->where(function ($query) {
                $query->where('transactions.status_payout', null);
                $query->where('transactions.status_refund', null);
            })->orWhere(function($query) {
                $query->where('transactions.status_payout', '!=', 'SUCCEEDED');
                $query->where('transactions.status_payout', '!=', null);
            })->orWhere(function($query) {
                $query->where('transactions.status_refund', '!=', 'SUCCEEDED');
                $query->where('transactions.status_refund', '!=', null);
            })
            ->get();

        $mangoPay = new MangoPayService();

        foreach($transactions as $transaction) {

            //If a claim exist for this transaction we check and update status
            if($transaction->claim_id) {
                //If claim is not resolved yet and seller has not replied
                //We check if the time limit is reached
                if($transaction->claim_status === null && $transaction->claim_seller === null) {

                    $dateNow = Carbon::now();
                    $date = Carbon::parse($transaction->claim_created_at);
                    $limitForSeller = $date->addHours(Claim::CLAIM_LIMIT_SELLER);

                    //If the limit is reached, then we resolve claim for Purchaser
                    if($dateNow > $limitForSeller) {
                        $claim = Claim::where('id', $transaction->claim_id)->first();
                        $claim->status = Claim::CLAIM_STATUS_WON;
                        $claim->save();

                        $transaction->claim_status = Claim::CLAIM_STATUS_WON;
                    }
                }

                //IF CLAIM STILL NOT RESOLVE WE JUMP TO THE NEXT LOOP
                if($transaction->claim_status === null) {
                    continue;
                }
            }

            //FROM HERE EVERY TRANSACTION HAS A CLAIM RESOLVED OR NO CLAIM AT ALL
            $Transaction = Transaction::where('id', $transaction->id)->first();

            //UPDATE OLD TRANSACTION STATUS
            //If a Payout exist we update status
            if($Transaction->status_payout !== 'SUCCEEDED' && $Transaction->status_payout !== null) {
                $payout = $mangoPay->getPayOut($Transaction->payout_id);

                if(isset($payout->Status)) {
                    //Update status Payout
                    $Transaction->status_payout = $payout->Status;
                } else {
                    $Transaction->status_payout = Transaction::STATUS_TRANSFER_FAIL;
                }
                $Transaction->save();
            }

            //If a refund exist we update status
            if($Transaction->status_refund !== 'SUCCEEDED' && $Transaction->status_refund !== null) {
                $refund = $mangoPay->getRefund($Transaction->refund_id);

                if(isset($refund->Status)) {
                    //Update status Payout
                    $Transaction->status_refund = $refund->Status;
                } else {
                    $Transaction->status_refund = Transaction::STATUS_TRANSFER_FAIL;
                }
                $Transaction->save();
            }

            //If transaction is fully complete no need to continue
            if($Transaction->status_refund === 'SUCCEEDED' && $Transaction->status_payout === 'SUCCEEDED') {
                continue;
            }

            //If Transaction is not complete or not started at all
            if(
                ($transaction->status_payout === null && $transaction->status_refund === null) OR
                ($transaction->status_payout !== 'SUCCEEDED' && $transaction->status_payout !== null) OR
                ($transaction->status_refund !== 'SUCCEEDED' && $transaction->status_refund !== null))
            {

                //If transaction has claim
                if($transaction->claim_id !== null) {

                    if($transaction->claim_status === Claim::CLAIM_STATUS_WON) {
                        //Refund
                        dump('Refund');
                        $refund = $mangoPay->createRefundPayIn($Transaction->transaction_mangopay, $Transaction->purchaser->mangopay_id);
                        //Update transaction Refund
                        if(isset($refund->Status)) {
                            $Transaction->status_refund = $refund->Status;
                            $Transaction->refund_id = $refund->Id;
                        } else {
                            $Transaction->status_refund = Transaction::STATUS_TRANSFER_FAIL;
                        }
                    }
                    elseif($transaction->claim_status === Claim::CLAIM_STATUS_LOST) {
                        //PayOut
                        dump('PayOut');

                        $bankAccount = $mangoPay->getBankAccount($Transaction->seller->mangopay_id);

                        if($bankAccount) {
                            $wallet = $mangoPay->getWallet($Transaction->wallet_id);
                            $payOut = $mangoPay->createPayOut($bankAccount, $Transaction->seller->mangopay_id, $wallet);
                            //Update transaction Payout
                            if (isset($payOut->Status)) {
                                $Transaction->status_payout = $payOut->Status;
                                $Transaction->payout_id = $payOut->Id;
                            } else {
                                $Transaction->status_payout = Transaction::STATUS_TRANSFER_FAIL;
                            }
                        }
                        else {
                            $Transaction->status_payout = Transaction::STATUS_NO_BANK_ACCOUNT;
                        }
                    }
                    elseif($transaction->claim_status === Claim::CLAIM_STATUS_EQUALITY) {
                        //Both
                        dump('both');
                        $bankAccount = $mangoPay->getBankAccount($Transaction->seller->mangopay_id);

                        $wallet = $mangoPay->getWallet($Transaction->wallet_id);
                        //We can split the amount of refund then give the rest to Seller
                        $refund = $mangoPay->createRefundPayIn($Transaction->transaction_mangopay, $Transaction->purchaser->mangopay_id, $wallet->Balance->Amount, true);

                        if(isset($refund->Status)) {
                            $Transaction->status_refund = $refund->Status;
                            $Transaction->refund_id = $refund->Id;
                        } else {
                            $Transaction->status_refund = Transaction::STATUS_TRANSFER_FAIL;
                        }

                        if($bankAccount) {
                            $payOut = $mangoPay->createPayOut($bankAccount, $Transaction->seller->mangopay_id, $wallet);
                            if (isset($payOut->Status)) {
                                $Transaction->status_payout = $payOut->Status;
                                $Transaction->payout_id = $payOut->Id;
                            } else {
                                $Transaction->status_payout = Transaction::STATUS_TRANSFER_FAIL;
                            }
                        }
                        else {
                            $Transaction->status_payout = Transaction::STATUS_NO_BANK_ACCOUNT;
                        }
                    }

                    $Transaction->save();
                    continue;
                }

                //The first time status is CREATED, but after we update status to make sure it is success
                //No need to continue PayOut if Success is made
                if ($Transaction->status === 'SUCCEEDED') {
                    continue;
                }

                $dateNow = Carbon::now();

                //If Transaction has no claim and date of departure is reached + time end limit claim
                if ($Transaction->ticket->date_before_transfer < $dateNow) {
                    dump('Payout');

                    $bankAccount = $mangoPay->getBankAccount($Transaction->seller->mangopay_id);

                    if (!$bankAccount) {
                        $Transaction->status_payout = Transaction::STATUS_NO_BANK_ACCOUNT;
                        $Transaction->save();
                        continue;
                    }

                    $wallet = $mangoPay->getWallet($Transaction->wallet_id);
                    $payOut = $mangoPay->createPayOut($bankAccount, $Transaction->seller->mangopay_id, $wallet);
                    //Update transaction Payout
                    if (isset($payOut->Status)) {
                        $Transaction->status_payout = $payOut->Status;
                        $Transaction->payout_id = $payOut->Id;
                    } else {
                        $Transaction->status_payout = Transaction::STATUS_TRANSFER_FAIL;
                    }

                    $Transaction->save();
                }
            }
        }

        dump('Done');
    }
}
