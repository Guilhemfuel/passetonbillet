<?php

namespace App\Http\Controllers\Hooks;

use App\Mail\FailPayoutEmail;
use App\Mail\SendFailKycEmail;
use App\Mail\SendSuccessKycEmail;
use App\Mail\SuccessPayoutEmail;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MangoPayController extends Controller
{
    public function KycSuccess(Request $data){
        if($data->RessourceId){
            $user = User::where('kyc_id', $data->RessourceId)->first();
            if(!$user){
                return redirect('404');
            }
            $user->kyc_status = Transaction::STATUS_TRANSFER_SUCCESS;
            $user->save();

            \Mail::to($user->email)->send(new SendSuccessKycEmail($user));

        }

        return "";
    }

    public function KycFailed(Request $data){
        if($data->RessourceId){
            $user = User::where('kyc_id', $data->RessourceId)->first();
            if(!$user){
                return redirect('404');
            }
            $user->kyc_status = Transaction::STATUS_TRANSFER_FAIL;
            $user->save();

            \Mail::to($user->email)->send(new SendFailKycEmail($user));
        }

        return "";
    }

    public function PayoutSuccess(Request $data){
        if($data->RessourceId){
            $transaction = Transaction::where('payout_id', $data->RessourceId)->first();
            if(!$transaction){
                return redirect('404');
            }
            $transaction->status_payout = Transaction::STATUS_TRANSFER_SUCCESS;
            $transaction->save();

            \Mail::to($transaction->seller->email)->send(new SuccessPayoutEmail($transaction->seller));
        }

        return "";
    }

    public function PayoutFailed(Request $data){
        if($data->RessourceId){
            $transaction = Transaction::where('payout_id', $data->RessourceId)->first();
            if(!$transaction){
                return redirect('404');
            }
            $transaction->status_payout = Transaction::STATUS_TRANSFER_FAIL;
            $transaction->save();

            \Mail::to($transaction->seller->email)->send(new FailPayoutEmail($transaction->seller));
        }

        return "";
    }
}
