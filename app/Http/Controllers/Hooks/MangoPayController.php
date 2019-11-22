<?php

namespace App\Http\Controllers\Hooks;

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
        }

        return "";
    }
}
