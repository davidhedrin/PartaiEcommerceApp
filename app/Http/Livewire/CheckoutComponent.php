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

    public function loadAllData() {
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

        return [
            "products" => $findProduct,
        ];
    }

    public function render()
    {
        return view('livewire.checkout-component', $this->loadAllData())->layout('layouts.base');
    }
}
