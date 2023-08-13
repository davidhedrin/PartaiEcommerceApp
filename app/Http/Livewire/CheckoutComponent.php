<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Product;
use App\Models\ShopingCart;
use App\Models\Voucher;
use App\Models\AddressUser;
use App\Models\PaymentMethod;
use App\Models\CheckoutProduct;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutComponent extends Component
{
    public $subTotalPriveAll = 0, $ppn = 0, $totalPriceToCheckout = 0;
    public $voucherVal = 0, $voucherCode;
    public $activeIdAddress, $select_payment_medhod;
    public $allPayment1, $po_creditCard;

    public $selected_va, $order_notes, $recipt_invoice;
    
    public function updated($fields){
        $rules = [
            "activeIdAddress" => "required",
            "select_payment_medhod" => "required",
        ];

        if($this->select_payment_medhod == "1"){
            $rules["selected_va"] = "required";
        }

        $this->validateOnly($fields, $rules);
    }

    public function mount($voucher = null){
        $this->voucherCode = $voucher;

        $this->allPayment1 = PaymentMethod::where("flag_active", true)->where("type", 1)->get();
        $this->po_creditCard = PaymentMethod::where("code", "po-007-debit")->where("flag_active", true)->first();

        $user = Auth::user();
        $allAddress = AddressUser::where("user_id", $user->id)->get();
        foreach($allAddress as $address){
            if($address->mark_as == "h"){
                $this->activeIdAddress = $address->id;
                break;
            }
        }
        
        $findProduct = ShopingCart::where("user_id", $user->id)->get();
        foreach($findProduct as $cart){
            if($cart->product->sale_price){
                $this->subTotalPriveAll += ($cart->product->regular_price-$cart->product->sale_price) * $cart->qty;
            }else {
                $this->subTotalPriveAll += $cart->product->regular_price * $cart->qty;
            }
        }
        $this->ppn = $this->subTotalPriveAll * 0.05;
        $this->totalPriceToCheckout += $this->subTotalPriveAll + $this->ppn;

        
        if($voucher){
            $findVoucher = Voucher::whereRaw('LOWER(code) = ?', strtolower($voucher))->first();
            if($findVoucher){
                if(Carbon::now() >= $findVoucher->exp_date || $findVoucher->flag_active === 0){
                    session()->flash('msgAlert', 'Maaf, voucher sudah tidak berlaku!');
                    session()->flash('msgStatus', 'Info');
                    return;
                }
                
                $allProductCart = ShopingCart::where("user_id", $user->id)->get();
                
                $allValidate = $this->subTotalPriveAll > $findVoucher->min_cart;
                if($allValidate){
                    foreach($allProductCart as $cart){
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
                        $this->totalPriceToCheckout = $getTotal - $findVoucher->value;
                        $this->voucherVal = $findVoucher->value;
                    }else{ // Voucher discount
                        $percent = ($findVoucher->value / 100);
                        $calculateDiscount = $getTotal * $percent;
                        $totalDiscount = $findVoucher->max_value_percent ? ($calculateDiscount > $findVoucher->max_value_percent ? $findVoucher->max_value_percent : $calculateDiscount) : $calculateDiscount;
                        $this->totalPriceToCheckout = $getTotal - $totalDiscount;
                        $this->voucherVal = $totalDiscount;
                    }
                    $voucher = strtoupper($voucher);
                    $this->totalPriceToCheckout += $this->ppn;
                }
            }else{
                $this->deleteCodeVocuher();
            }
        }
    }

    public function updateCardTotal(){
        $this->subTotalPriveAll = $this->getTotalCartUser();
        $this->ppn = $this->subTotalPriveAll * 0.05;
        $this->totalPriceToCheckout = $this->subTotalPriveAll + $this->ppn;
    }

    public function deleteCodeVocuher(){
        $this->voucherVal = 0;
        $this->voucherCode = null;
        $this->updateCardTotal();
    }
    
    public function getTotalCartUser(){
        $result = 0;
        $findProduct = ShopingCart::where("user_id", Auth::user()->id)->get();
        foreach($findProduct as $cart){
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

        if($this->select_payment_medhod == "1"){
            $rules["selected_va"] = "required";
        }

        $this->validate($rules);

        HalperFunctions::SaveWithTransaction(
            function(){
                $auth = Auth::user();
                $findProduct = ShopingCart::where("user_id", $auth->id)->get();
                $findVoucher = $this->voucherCode ? Voucher::where("code", $this->voucherCode)->first() : null;

                $uuid = Str::uuid();
                $generateTransCode = Carbon::now()->timestamp . HalperFunctions::generateRandomCode(10);

                $setTrans = new Transaction;
                $setTrans->id = $uuid;
                $setTrans->user_id = $auth->id;
                $setTrans->voucher_id = $findVoucher ? $findVoucher->id : null;
                $setTrans->address_id = $this->activeIdAddress;
                $setTrans->trans_code = $generateTransCode;
                $setTrans->payment = $this->select_payment_medhod  == "1" ? $this->selected_va : $this->select_payment_medhod;
                $setTrans->order_note = $this->order_notes;
                $setTrans->save();

                foreach($findProduct as $product){
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
                return redirect()->route('home');
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
