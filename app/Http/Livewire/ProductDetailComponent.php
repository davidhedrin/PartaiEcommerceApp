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

class ProductDetailComponent extends Component
{
    public $productId, $quntity = 1;

    public function mount($product_id) {
        $this->productId = $product_id;
    }
    
    public function detailProductExport($id) {
        return redirect()->route('product.detail', ['product_id' => $id]);
    }

    public function increaseQty() {
        $this->quntity++;
    }
    public function decreaseQty() {
        $this->quntity > 1 && $this->quntity --;
    }

    public function addProductToCart() {
        $findProduct = Product::find($this->productId);
        if($findProduct->stock_status){
            HalperFunctions::SaveWithTransaction(
                function() {
                    $userId = Auth::user()->id;
                    $cartProduct = ShopingCart::where("user_id", $userId)->where("product_id", $this->productId)->first();
    
                    if($cartProduct){
                        $cartProduct->qty = $cartProduct->qty + $this->quntity;
                        $cartProduct->save();
                    }else{
                        $product = new ShopingCart;
                        $product->user_id = $userId;
                        $product->product_id = $this->productId;
                        $product->qty = $this->quntity;
                        $product->save();
                    }
    
                    session()->flash('msgAlert', 'Product berhasil ditambahkan ke keranjang');
                    session()->flash('msgStatus', 'Success');
                },
                "addProductToCart"
            );
            
            $this->emit('updateCartCount');
        }
    }

    public function addNewToCart($productId){
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

    public function loadAllData() {
        $getProduct;
        $randomProduct = Product::inRandomOrder()->limit(6)->get();
        if (!empty(trim($this->productId))) {
            $getProduct = Product::find($this->productId);
        }

        return [
            'product' => $getProduct,
            'randomProduct' => $randomProduct
        ];
    }

    public function render()
    {
        return view('livewire.product-detail-component', $this->loadAllData())->layout('layouts.base');
    }
}
