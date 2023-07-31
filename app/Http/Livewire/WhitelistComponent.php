<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Product;
use App\Models\ShopingCart;
use App\Models\Whitelist;
use Livewire\WithPagination;

class WhitelistComponent extends Component
{
    use WithPagination;
    public $totalWhitelist = 0;

    public function addProductToCart($productId) {
        HalperFunctions::SaveWithTransaction(
            function() use($productId) {
                $userId = Auth::user()->id;
                $findProduct = ShopingCart::where("user_id", $userId)->where("product_id", $productId)->first();

                if($findProduct){
                    $findProduct->qty++;
                    $findProduct->save();
                }else{
                    $product = new ShopingCart;
                    $product->user_id = $userId;
                    $product->product_id = $productId;
                    $product->qty = 1;
                    $product->save();
                }

                session()->flash('msgAlert', 'Product berhasil ditambahkan ke keranjang');
                session()->flash('msgStatus', 'Success');
                return redirect()->route('shoping-cart');
            },
            "addProductToCart"
        );
    }
    
    public function addToWhitelist($productId){
        $throttleKey = request()->ip() . "addToWhitelist" . $productId;
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 3, 1);
        if (!$rateLimitNotExceeded) return;

        HalperFunctions::addRemoveWhitelist($productId, true);
        $this->emit('updateWhitelistCount');
    }
    public function removeWhitelist($productId){
        HalperFunctions::addRemoveWhitelist($productId, false);
        $this->emit('updateWhitelistCount');
    }
    
    public function loadAllData(){
        $this->totalWhitelist = Whitelist::where('user_id', Auth::user()->id)->where('flag_active', true)->count();
        $allProducts = Whitelist::where("flag_active", true)->get();
        $randomProduct = Product::inRandomOrder()->limit(6)->get();
        
        return [
            'allProducts' => $allProducts,
            'randomProduct' => $randomProduct
        ];
    }

    public function render()
    {
        return view('livewire.whitelist-component', $this->loadAllData())->layout('layouts.base');
    }
}
