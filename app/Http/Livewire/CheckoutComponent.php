<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\ShopingCart;
use App\Models\Voucher;
use App\Models\AddressUser;
use App\Models\Country;
use App\Models\PaymentMethod;
use App\Models\PaymentTransaction;
use App\Models\CheckoutProduct;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutComponent extends Component
{
    public $subTotalPriceAll = 0, $ppn = 0, $totalPriceToCheckout = 0;
    public $voucherVal = 0, $voucherCode;
    public $activeIdAddress, $select_payment_medhod;
    public $allPaymentMethod, $allPayment1, $po_creditCard;

    public $selected_va, $order_notes, $recipt_invoice;
    public $payment_fee_name, $payment_fee_value;

    public $saveAllFindProduct;
    
    public function updated($fields){
        $rules = [
            "activeIdAddress" => "required",
            "select_payment_medhod" => "required",
        ];

        if($this->select_payment_medhod == "va"){
            $rules["selected_va"] = "required";
        }

        $this->validateOnly($fields, $rules);
    }

    public function mount($voucher = null){
        $this->voucherCode = $voucher;

        $this->allPaymentMethod = PaymentMethod::all();
        $filteredPaymentMethods = $this->allPaymentMethod->where("flag_active", true);
        $this->allPayment1 = $filteredPaymentMethods->where("type", 1);
        $this->po_creditCard = $filteredPaymentMethods->where("type", 2);

        $user = Auth::user();
        $allAddress = AddressUser::where("user_id", $user->id)->get();
        foreach($allAddress as $address){
            if($address->mark_as == "h"){
                $this->activeIdAddress = $address->id;
                break;
            }
        }
        
        $findProduct = ShopingCart::where("user_id", $user->id)->get();
        $this->saveAllFindProduct = $findProduct;
        $this->setTotalSummary();
    }

    public function setTotalSummary(){
        $user = Auth::user();
        $setSubTotalPriceAll = 0;
        foreach($this->saveAllFindProduct as $cart){
            if($cart->product->sale_price){
                $setSubTotalPriceAll += ($cart->product->regular_price-$cart->product->sale_price) * $cart->qty;
            }else {
                $setSubTotalPriceAll += $cart->product->regular_price * $cart->qty;
            }
        }

        $this->subTotalPriceAll = $setSubTotalPriceAll;
        $this->ppn = $setSubTotalPriceAll * 0.05;
        $this->totalPriceToCheckout = $setSubTotalPriceAll + $this->ppn;

        
        if($this->voucherCode){
            $getResultVoucher = $this->getVoucherValue($this->voucherCode, $user);
            $this->totalPriceToCheckout -= $getResultVoucher;
        }
    }

    public function getVoucherValue($voucher, $user){
        $result = 0;

        $findVoucher = Voucher::whereRaw('LOWER(code) = ?', strtolower($voucher))->first();
        if($findVoucher){
            if(Carbon::now() >= $findVoucher->exp_date || $findVoucher->flag_active === 0){
                session()->flash('msgAlert', 'Maaf, voucher sudah tidak berlaku!');
                session()->flash('msgStatus', 'Info');
                return;
            }
            
            $allValidate = $this->subTotalPriceAll > $findVoucher->min_cart;
            if($allValidate){
                foreach($this->saveAllFindProduct as $cart){
                    if($findVoucher->for_product != null){
                        if($cart->product->product_for !== $findVoucher->for_product){
                            $allValidate = false;
                            break;
                        }
                    }
                    if($findVoucher->product_discont == 0){
                        if($cart->product->sale_price !== null){
                            $allValidate = false;
                            break;
                        }
                    }
                }
            }

            if($allValidate){
                $getTotal = $this->getTotalCartUser();
                if($findVoucher->type == "fixed"){ // Voucher fixed
                    $result = $findVoucher->value;
                    $this->voucherVal = $findVoucher->value;
                }else{ // Voucher discount
                    $percent = ($findVoucher->value / 100);
                    $calculateDiscount = $getTotal * $percent;
                    $totalDiscount = $findVoucher->max_value_percent ? ($calculateDiscount > $findVoucher->max_value_percent ? $findVoucher->max_value_percent : $calculateDiscount) : $calculateDiscount;
                    $result = $totalDiscount;
                    $this->voucherVal = $totalDiscount;
                }
                $voucher = strtoupper($voucher);
            }
        }else{
            $this->deleteCodeVocuher();
        }

        return $result;
    }

    public function paymentMethodFee($value){
        $this->payment_fee_name = null;
        $this->payment_fee_value = null;

        if($value == "va" || $value == "" || !$value){
            $this->setTotalSummary();
            $this->selected_va = null;
            return false;
        }

        $this->payment_fee_value = 0;
        $findPo = $this->allPaymentMethod->find($value);
        if($findPo){
            $this->payment_fee_name = $findPo->name . " " . ($findPo->fee_percent ? $findPo->fee_percent."%" : "") . ($findPo->fee_fixed && $findPo->fee_percent ? " + " . HalperFunctions::currencyIDR($findPo->fee_fixed) : "");
            if($findPo->fee_fixed) {
                $this->payment_fee_value += $findPo->fee_fixed;
            }
            if($findPo->fee_percent) {
                $this->payment_fee_value += $this->getTotalCartUser() * ($findPo->fee_percent/100);
            }

            $ifVoucher = $this->voucherCode ? $this->getVoucherValue($this->voucherCode, Auth::user()) : 0;
            $this->totalPriceToCheckout -= $ifVoucher;
            
            $this->subTotalPriceAll = $this->getTotalCartUser();
            $this->ppn = $this->subTotalPriceAll * 0.05;
            $this->totalPriceToCheckout = $this->subTotalPriceAll + $this->ppn + $this->payment_fee_value;
        }else{
            $this->payment_fee_name = null;
            $this->payment_fee_value = null;
            $this->selected_va = null;
            $this->updateCardTotal();
        }
    }

    public function updateCardTotal(){
        $this->subTotalPriceAll = $this->getTotalCartUser();
        $this->ppn = $this->subTotalPriceAll * 0.05;
        $this->totalPriceToCheckout = $this->subTotalPriceAll + $this->ppn;
    }

    public function deleteCodeVocuher(){
        $this->voucherVal = 0;
        $this->voucherCode = null;
        $this->updateCardTotal();
    }
    
    public function getTotalCartUser(){
        $result = 0;
        foreach($this->saveAllFindProduct as $cart){
            if($cart->product->sale_price){
                $result += ($cart->product->regular_price-$cart->product->sale_price) * $cart->qty;
            }else {
                $result += $cart->product->regular_price * $cart->qty;
            }
        }

        return $result;
    }

    public function placeOrderCart(){
        if(!$this->activeIdAddress){
            session()->flash('msgAlert', 'Please arrange and specify the address of the goods to be delivered first.');
            session()->flash('msgStatus', 'Warning');
        };

        $rules = [
            "activeIdAddress" => "required",
            "select_payment_medhod" => "required",
        ];

        if($this->select_payment_medhod == "va"){
            $rules["selected_va"] = "required";
        }

        $this->validate($rules);

        $throttleKey = request()->ip() . "placeOrderCart";
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 10, 5);
        if (!$rateLimitNotExceeded) return;

        HalperFunctions::SaveWithTransaction(
            function(){
                $auth = Auth::user();
                $uuid = Str::uuid();
                $findAddress = AddressUser::find($this->activeIdAddress);
                $findVoucher = $this->voucherCode ? Voucher::where("code", $this->voucherCode)->first() : null;
                $generateTransCode = Carbon::now()->timestamp . HalperFunctions::generateRandomCode(10);

                $valuePaymentMethod = $this->select_payment_medhod  == "va" ? $this->selected_va : $this->select_payment_medhod;
                $findPo = PaymentMethod::find($valuePaymentMethod);

                $serverKeyMidtrans = config('midtrans.key');
                $urlSendboxMidtrans = config('midtrans.url_sendbox');
                $urlProdutionKeyMidtrans = config('midtrans.url_production');

                $bodyMidtrans = [
                    "payment_type" => $findPo->payment_type,
                    "transaction_details" => [
                        "order_id" => $uuid,
                        "gross_amount" => $this->totalPriceToCheckout
                    ],
                ];

                // BNI, BRI, CIMB
                if($findPo->code == "po-002" || $findPo->code == "po-003" || $findPo->code == "po-004"){
                    $bodyMidtrans["bank_transfer"] = [
                        "bank" => $findPo->bank_transfer
                    ];
                }
                // Mandiri
                if($findPo->code == "po-005"){
                    $bodyMidtrans["echannel"] = [
                        "bill_info1" => "Payment",
                        "bill_info2" => "Jakarta Trading"
                    ];
                }

                // Customer Detail
                $bodyMidtrans["customer_details"] = [
                    "first_name" => $auth->name,
                    "last_name" => null,
                    "email" => $auth->email,
                    "phone" => $auth->no_ponsel,
                    "shipping_address" => [
                        "first_name" => $auth->name,
                        "last_name" => null,
                        "email" => $auth->email,
                        "phone" => $findAddress->contact,
                        "address" => $findAddress->address,
                        "city" => $findAddress->city,
                        "postal_code" => $findAddress->post_code,
                        "country_code" => $findAddress->country->sortname
                    ],
                ];

                $resJsonMidtrans = Http::withBasicAuth($serverKeyMidtrans, '')->post($urlSendboxMidtrans, $bodyMidtrans);
                if($resJsonMidtrans->failed()) { 
                    DB::rollback();
                    session()->flash('msgAlert', 'Transaction cannot be forwarded. Try again in a few moments!');
                    session()->flash('msgStatus', 'Info');
                    return false;
                }

                $resObjMidtrans = json_decode($resJsonMidtrans);
                if($resObjMidtrans->status_code != "201") { 
                    DB::rollback();
                    session()->flash('msgAlert', "Transaction cannot be forwarded. $resObjMidtrans->status_message");
                    session()->flash('msgStatus', 'Info');
                    return false;
                }

                $setTrans = new Transaction;
                $setTrans->id = $uuid;
                $setTrans->user_id = $auth->id;
                $setTrans->voucher_id = $findVoucher ? $findVoucher->id : null;
                $setTrans->address_id = $this->activeIdAddress;
                $setTrans->trans_code = $generateTransCode;
                $setTrans->payment_id = $valuePaymentMethod;
                $setTrans->order_note = $this->order_notes;
                $setTrans->save();

                $getVaNumberResponse = null;
                if($findPo->code == "po-002" || $findPo->code == "po-003" || $findPo->code == "po-004"){
                    $getVaNumberResponse = $resObjMidtrans->va_numbers[0]->va_number;
                }else if($findPo->code == "po-006"){
                    $getVaNumberResponse = $resObjMidtrans->permata_va_number;
                }
                $payment_transaction = new PaymentTransaction;
                $payment_transaction->trans_id = $uuid;
                $payment_transaction->user_id = $auth->id;   
                $payment_transaction->va = $getVaNumberResponse;
                $payment_transaction->amounts = $this->totalPriceToCheckout;
                $payment_transaction->payment_id = $valuePaymentMethod;
                $payment_transaction->midtrans_response = $resJsonMidtrans;
                $payment_transaction->expiry_time = $resObjMidtrans->expiry_time ?? null;
                $payment_transaction->save();

                foreach($this->saveAllFindProduct as $product){
                    $co_prod = new CheckoutProduct;
                    $co_prod->trans_id = $uuid;
                    $co_prod->product_id = $product->product_id;
                    $co_prod->qty = $product->qty;
                    $co_prod->price = $product->product->regular_price;
                    $co_prod->sale = $product->product->sale_price;
                    $co_prod->save();
                    $product->delete();
                }

                session()->flash('msgAlert', 'Congratulations, your transaction has been successfully requested. Please pay to complete.');
                session()->flash('msgStatus', 'Success');
                return redirect()->route('transaction-detail', ['trans_id' => $uuid]);
            },
            "placeOrderCart"
        );
    }

    public function loadAllData() {
        $user = Auth::user();
        $findProduct = ShopingCart::where("user_id", $user->id)->get();
        $allAddress = AddressUser::where("user_id", $user->id)->get();

        return [
            "products" => $findProduct,
            "allAddress" => $allAddress,
        ];
    }

    public function render()
    {
        return view('livewire.checkout-component', $this->loadAllData())->layout('layouts.base');
    }
}

// $findVoucher = Voucher::whereRaw('LOWER(code) = ?', strtolower($voucher))->first();
// if($findVoucher){
//     if(Carbon::now() >= $findVoucher->exp_date || $findVoucher->flag_active === 0){
//         session()->flash('msgAlert', 'Maaf, voucher sudah tidak berlaku!');
//         session()->flash('msgStatus', 'Info');
//         return;
//     }
    
//     $allProductCart = ShopingCart::where("user_id", $user->id)->get();
    
//     $allValidate = $this->subTotalPriceAll > $findVoucher->min_cart;
//     if($allValidate){
//         foreach($allProductCart as $cart){
//             if($findVoucher->for_product != null){
//                 if($cart->product->product_for !== $findVoucher->for_product){
//                     $allValidate = false;
//                     break;
//                 }
//             }
//             if($findVoucher->product_discont == 0){
//                 if($cart->product->sale_price !== null){
//                     $allValidate = false;
//                     break;
//                 }
//             }
//         }
//     }

//     if($allValidate){
//         $getTotal = $this->getTotalCartUser();
//         if($findVoucher->type == "fixed"){ // Voucher fixed
//             $this->totalPriceToCheckout = $getTotal - $findVoucher->value;
//             $this->voucherVal = $findVoucher->value;
//         }else{ // Voucher discount
//             $percent = ($findVoucher->value / 100);
//             $calculateDiscount = $getTotal * $percent;
//             $totalDiscount = $findVoucher->max_value_percent ? ($calculateDiscount > $findVoucher->max_value_percent ? $findVoucher->max_value_percent : $calculateDiscount) : $calculateDiscount;
//             $this->totalPriceToCheckout = $getTotal - $totalDiscount;
//             $this->voucherVal = $totalDiscount;
//         }
//         $voucher = strtoupper($voucher);
//         $this->totalPriceToCheckout += $this->ppn;
//     }
// }else{
//     $this->deleteCodeVocuher();
// }