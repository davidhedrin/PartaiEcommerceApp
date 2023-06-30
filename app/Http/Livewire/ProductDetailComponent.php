<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Product;
use App\Models\ImageProduct;
use App\Models\Category;

class ProductDetailComponent extends Component
{
    public $productId;
    
    public function mount($product_id) {
        $this->productId = $product_id;
    }

    public function loadAllData() {
        $getProduct;
        $randomProduct = Product::inRandomOrder()->limit(5)->get();
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
