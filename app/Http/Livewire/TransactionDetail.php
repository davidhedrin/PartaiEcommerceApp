<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Http;
use App\Models\CheckoutProduct;
use App\Models\PaymentMethod;
use App\Models\Transaction;

class TransactionDetail extends Component
{
    public $uuid, $findTrans;
    public $totalAmountsPrice = 0, $getTotalProducts = 0, $ppn = 0;
    public $voucherName, $dicountVoucher = 0;
    public $payment_fee_value = 0, $payment_fee_name;

    public function mount($trans_id){
        $this->uuid = $trans_id;
        
        try {
            $uuid = Uuid::fromString($this->uuid);
            $getTrans = Transaction::find($uuid);
            $this->findTrans = $getTrans;
            
            //Set Total Product and if have Voucher
            $totalCheckoutProduct = HalperFunctions::totalCheckoutProduct($getTrans->products);
            $ifVoucher = HalperFunctions::transactionWithVoucher($totalCheckoutProduct, $getTrans->voucher);
            $this->voucherName = $getTrans->voucher ? $getTrans->voucher->code : null;
            $this->getTotalProducts = $totalCheckoutProduct;
            
            //Calculate Total To PPN
            $this->ppn = $totalCheckoutProduct * 0.05;
            $totalCheckoutProduct += $this->ppn;
            
            //Calculate Payment FEE
            if($getTrans->payment->fee_fixed) {
                $this->totalAmountsPrice += $totalCheckoutProduct + $getTrans->payment->fee_fixed;
            }
            if($getTrans->payment->fee_percent) {
                $this->totalAmountsPrice += $totalCheckoutProduct + ($totalCheckoutProduct * ($getTrans->payment->fee_percent/100));
            }
            
            //Calculate if have Voucher
            $this->totalAmountsPrice -= $ifVoucher;
            $this->dicountVoucher = $ifVoucher;
            
            $findPo = PaymentMethod::find($getTrans->payment_id);
            if($findPo){
                $this->payment_fee_name = $findPo->name . " " . ($findPo->fee_percent ? $findPo->fee_percent."%" : "") . ($findPo->fee_fixed && $findPo->fee_percent ? " + " . HalperFunctions::currencyIDR($findPo->fee_fixed) : "");
                if($findPo->fee_fixed) {
                    $this->payment_fee_value += $findPo->fee_fixed;
                }
                if($findPo->fee_percent) {
                    $this->payment_fee_value += $this->getTotalCartUser() * ($findPo->fee_percent/100);
                }
            }
        } catch (Exception $e) {
        }
    }
    
    public function cancelTransaction($order_id){
        // $getStatusOrder = json_decode(HalperFunctions::getStatusTransactionMidtrans($order_id));
        
        // if($getStatusOrder->transaction_status == "pending"){
        //     $uuid = Uuid::fromString($order_id);
        //     $getTrans = Transaction::find($uuid);

        //     if($getTrans->status_id == 1){
        //         $serverKeyMidtrans = config('midtrans.key');
        //         $urlSendboxMidtrans = config('midtrans.url_sendbox') . "/$order_id/cancel";
        //         $urlProdutionKeyMidtrans = config('midtrans.url_production') . "/$order_id/cancel";
                
        //         $resJsonMidtrans = Http::withBasicAuth($serverKeyMidtrans, '')->post($urlSendboxMidtrans);
        //         if($resJsonMidtrans->failed()){
        //             HalperFunctions::insertLogError($getTrans->user->email, "cancelTransaction", "POST", json_decode($resJsonMidtrans)->status_message);
        //             session()->flash('msgAlert', 'Transaction cannot be forwarded. Try again in a few moments!');
        //             session()->flash('msgStatus', 'Info');
        //             return false;
        //         }
    
        //         $getTrans->status_id = 6;
        //         $getTrans->flag_active = false;
        //         $getTrans->save();
    
        //         session()->flash('msgAlert', 'Your transaction has been successfully cancelled');
        //         session()->flash('msgStatus', 'Success');
        //         return redirect()->route('transaction-detail', ['trans_id' => $order_id]);
        //     }
        // }
    }
    
    public function copyToClipboard($text){
        $this->dispatchBrowserEvent('hit-function-copy', ["code" => trim($text)]);

        session()->flash('msgAlert', 'The text has been successfully copied');
        session()->flash('msgStatus', 'Success');
    }
    
    public function render()
    {
        return view('livewire.transaction-detail')->layout('layouts.base');
    }
}