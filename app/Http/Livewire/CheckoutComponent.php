<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Product;
use App\Models\ShopingCart;
use App\Models\Voucher;
use Carbon\Carbon;

class CheckoutComponent extends Component
{
    public $subTotalPriveAll = 0, $ppn = 0, $totalPriceToCheckout = 0;
    public $voucherVal = 0, $voucherCode;

    public function mount($voucher = null){
        $this->voucherCode = $voucher;
        
        $findProduct = ShopingCart::where("user_id", Auth::user()->id)->get();
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
                
                $allProductCart = ShopingCart::where("user_id", Auth::user()->id)->get();
                
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

    public function loadAllData() {
        $findProduct = ShopingCart::where("user_id", Auth::user()->id)->get();

        return [
            "products" => $findProduct,
        ];
    }

    public function render()
    {
        return view('livewire.checkout-component', $this->loadAllData())->layout('layouts.base');
    }
}
