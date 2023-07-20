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
    public function decreaseQty($id, $qty){
        if($qty > 1){
            $findProduct = ShopingCart::find($id);
            $findProduct->qty--;
            $findProduct->save();
        }
    }
    public function increaseQty($id, $qty){
        $findProduct = ShopingCart::find($id);
        $findProduct->qty++;
        $findProduct->save();
    }
    public function deleteProductCart($id){
        $findProduct = ShopingCart::find($id);
        $findProduct->delete();
        $this->emit('updateCartCount');
    }

    public function loadAllData() {
        $findProduct = ShopingCart::where("user_id", Auth::user()->id)->get();

        return [
            "products" => $findProduct,
        ];
    }

    public function render()
    {
        return view('livewire.cart-component', $this->loadAllData())->layout('layouts.base');
    }
}
