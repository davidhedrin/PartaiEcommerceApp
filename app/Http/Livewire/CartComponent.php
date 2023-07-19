<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Product;
use App\Models\ShopingCart;

class CartComponent extends Component
{
    public $total = 0, $subTotal = 0, $ppn = 0;
    public $tempAllProduct = [];

    public function deleteProduct($id) {
        HalperFunctions::SaveWithTransaction(
            function() use($id) {
                $cartUser = ShopingCart::where('user_id', Auth::user()->id)->first();
                foreach ($this->tempAllProduct as $key => $item) {
                    if ($item['id'] === $id) {
                        unset($this->tempAllProduct[$key]);
                        break;
                    }
                }

                $getCurrentProduct = [];
                foreach($this->tempAllProduct as $product){
                    $getCurrentProduct[] = [
                        "product_id" => $product['id'],
                        "qty" => $product['qty']
                    ];
                }
                $cartUser->products = json_encode($getCurrentProduct);
                $cartUser->save();
            },
            "deleteProduct"
        );
    }

    public function loadAllData() {
        $this->total = 0; $this->subTotal = 0; $this->ppn = 0;
        $cartUser = ShopingCart::where('user_id', Auth::user()->id)->first();

        $allProductCart = [];
        if($cartUser){
            $cartItem = json_decode($cartUser->products);
            foreach($cartItem as $item){
                $product = Product::find($item->product_id);
                $product->setAttribute('qty', $item->qty);
                $allProductCart[] = $product;
    
                $total = $product->regular_price * $item->qty;
                $this->subTotal = $this->subTotal + $total;
            }
            
            $this->tempAllProduct = $allProductCart;
            $this->ppn = $this->subTotal * 0.05;
            $this->total = $this->subTotal + $this->ppn;
        }
        
        return [
            "products" => $allProductCart,
        ];
    }

    public function render()
    {
        return view('livewire.cart-component', $this->loadAllData())->layout('layouts.base');
    }
}
