<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use Ramsey\Uuid\Uuid;
use App\Models\Transaction;
use App\Models\MidtransHistory;

class HandleNotifPaymentMidtransController extends Controller
{
    public function __invoke(Request $request)
    {
        try{
            $payload = $request->all();
    
            $hashSignature = hash('sha512', $payload['order_id'].$payload['status_code'].$payload['gross_amount'].config('midtrans.key'));
            if($hashSignature != $payload['signature_key']){
                HalperFunctions::insertLogError("Midtrans", "HistoryAndUpdateNotif", "HASH", "Signature is not match or incorect");
                return false;
            }
    
            $uuid = Uuid::fromString($payload['order_id']);
    
            $findTransaction = Transaction::find($uuid);
            if(!$findTransaction){
                HalperFunctions::insertLogError("Midtrans", "HistoryAndUpdateNotif", "GET", "Transaction is not found");
                return false;
            }
    
            HalperFunctions::SaveWithTransaction(
                function() use($uuid, $findTransaction, $payload){
                    $newHistory = new MidtransHistory;
                    $newHistory->trans_id = $uuid;
                    $newHistory->status = $payload['transaction_status'];
                    $newHistory->status_code = $payload['status_code'];
                    $newHistory->response = json_encode($payload);
                    $newHistory->save();
            
                    if($payload['transaction_status'] == 'settlement' || $payload['transaction_status'] == 'capture'){
                        $findTransaction->status = 2;
                    }
                    if($payload['transaction_status'] == 'expire' || $payload['transaction_status'] == 'failure'){
                        $findTransaction->status = null;
                        $findTransaction->flag_active = false;
                    }
            
                    $findTransaction->save();
                },
                "HistoryAndUpdate"
            );
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError("Midtrans", "HistoryAndUpdateNotif", "POST", $error_msg." | ".$stackTrace);
        }
    }
}
