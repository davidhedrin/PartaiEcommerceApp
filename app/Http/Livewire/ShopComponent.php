<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Product;
use App\Models\ShopingCart;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

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
    
    public function addRemoveWhitelist($productId, $action){
        HalperFunctions::addRemoveWhitelist($productId, !$action);
        $this->emit('updateWhitelistCount');
    }

    public function loadAllData(){
        $allProducts = HalperFunctions::filterWhitelistProduct(Product::paginate(12));
        $latestProducts = HalperFunctions::filterWhitelistProduct(Product::orderBy("created_at", "desc")->paginate(6));
        $ltsProdCollection = $latestProducts->getCollection();
        $ltsProd1 = $ltsProdCollection->take(3);
        $ltsProd2 = $ltsProdCollection->skip(3)->take(3);
        $saleOffProducts = HalperFunctions::filterWhitelistProduct(Product::whereNotNull("sale_price")->inRandomOrder()->take(6)->get());
        
        return [
            "allProducts" => $allProducts,
            "ltsProd1" => $ltsProd1,
            "ltsProd2" => $ltsProd2,
            "saleOffProducts" => $saleOffProducts
        ];
    }

    public function render()
    {
        return view('livewire.shop-component', $this->loadAllData())->layout('layouts.base');
    }
}
