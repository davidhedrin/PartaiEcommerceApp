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
        $product = [
            "product_id" => $this->productId,
            "qty" => $this->quntity
        ];

        HalperFunctions::SaveWithTransaction(
            function() use($product) {
                $findCart = ShopingCart::where("user_id", Auth::user()->id)->first();
                if($findCart){
                    $notExist = true;
                    $setProduct = json_decode($findCart->products, true);
                    foreach ($setProduct as &$item) {
                        if ($item['product_id'] == $this->productId) {
                            $item['qty'] = intval($item['qty']) + $this->quntity;
                            $notExist = false;
                            break;
                        }
                    }
                    if($notExist){
                        $setProduct[] = $product;
                    }
                    $findCart->products = json_encode($setProduct);
                    $findCart->save();
                }else{
                    $setProduct = [];
                    $setProduct[] = $product;
                    $new = new ShopingCart;
                    $new->user_id = Auth::user()->id;
                    $new->products = json_encode($setProduct);
                    $new->save();
                }

                session()->flash('msgAlert', 'Product berhasil ditambahkan ke keranjang');
                session()->flash('msgStatus', 'Success');
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
