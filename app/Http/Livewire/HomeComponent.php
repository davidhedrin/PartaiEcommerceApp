<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Product;
use App\Models\ImageProduct;
use App\Models\Category;
use App\Models\ShopingCart;
use App\Models\Whitelist;
use Livewire\WithPagination;

class HomeComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function detailProductExport($id) {
        return redirect()->route('product.detail', ['product_id' => $id]);
    }

    public function addProductToCart($productId) {
        if(Auth::user()){
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
        }else{
            return redirect()->route('login');
        }
    }

    public function addRemoveWhitelist($productId, $action){
        if(Auth::user()){
            $throttleKey = request()->ip() . "addRemoveWhitelist". $productId;
            $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 5, 1);
            if (!$rateLimitNotExceeded) return;
    
            HalperFunctions::addRemoveWhitelist($productId, !$action);
            $this->emit('updateWhitelistCount');
        }else{
            return redirect()->route('login');
        }
    }

    public function loadAllData() {
        $allProductImport = Product::where('product_for', 'i')->paginate();
        $allProductExport = HalperFunctions::filterWhitelistProduct(Product::where('product_for', 'e')->paginate(8));

        return [
            "allProductImport" => $allProductImport,
            "allProductExport" => $allProductExport,
        ];
    }

    public function render()
    {
        return view('livewire.home-component', $this->loadAllData())->layout('layouts.base');
    }
}
