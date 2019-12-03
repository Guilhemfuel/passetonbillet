<?php

namespace App\Http\Controllers\Hooks;

use App\Mail\FailPayoutEmail;
use App\Mail\SendFailKycEmail;
use App\Mail\SendSuccessKycEmail;
use App\Mail\SuccessPayoutEmail;
use App\Notifications\FailPayoutNotification;
use App\Notifications\SendFailKycNotification;
use App\Notifications\SendSuccessKycNotification;
use App\Notifications\SuccessPayoutNotification;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MangoPayController extends Controller
{
    public function KycSuccess(Request $data) {

        $data->validate([
            'RessourceId' => 'required',
        ]);

        $user = User::where('kyc_id', $data->RessourceId)->first();
        if (!$user) {
            return redirect('404');
        }
        $user->kyc_status = Transaction::STATUS_TRANSFER_SUCCESS;
        $user->save();

        $user->notify((new SendSuccessKycNotification($user)));

        return "";
    }

    public function KycFailed(Request $data){

        $data->validate([
            'RessourceId' => 'required',
        ]);

        $user = User::where('kyc_id', $data->RessourceId)->first();
        if (!$user) {
            return redirect('404');
        }
        $user->kyc_status = Transaction::STATUS_TRANSFER_FAIL;
        $user->save();

        $user->notify((new SendFailKycNotification($user)));

        return "";
    }

    public function PayoutSuccess(Request $data){

        $data->validate([
            'RessourceId' => 'required',
        ]);

        $transaction = Transaction::where('payout_id', $data->RessourceId)->first();
        if (!$transaction) {
            return redirect('404');
        }
        $transaction->status_payout = Transaction::STATUS_TRANSFER_SUCCESS;
        $transaction->save();

        $transaction->seller->notify((new SuccessPayoutNotification($transaction->seller)));

        return "";
    }

    public function PayoutFailed(Request $data){

        $data->validate([
            'RessourceId' => 'required',
        ]);

        $transaction = Transaction::where('payout_id', $data->RessourceId)->first();
        if (!$transaction) {
            return redirect('404');
        }
        $transaction->status_payout = Transaction::STATUS_TRANSFER_FAIL;
        $transaction->save();

        $transaction->seller->notify((new FailPayoutNotification($transaction->seller)));

        return "";
    }
}
