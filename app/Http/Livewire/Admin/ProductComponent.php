<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\Product;
use App\Models\ImageProduct;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $image, $short_desc, $description, $regular_price, $sale_price;
    public $sku, $featured = false, $quantity, $images = [], $category_id, $product_for;
    public $initProductFor =  false, $loadingSku = false, $setImg;

    public function updated($fields) {
        $this->validateOnly($fields, [
            'name' => 'required',
            'product_for' => 'required',
            'regular_price' => 'required',
            'quantity' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        
        if($this->setImg){
            $this->images[] = $this->setImg;
            $this->setImg = null;
        }
    }

    public function resetImageVal() {
        $this->image = null;
    }

    public function reselFormValue() {
        $this->name = null;
        $this->image = null;
        $this->short_desc = null;
        $this->description = null;
        $this->regular_price = null;
        $this->sale_price = null;
        $this->sku = null;
        $this->featured = false;
        $this->quantity = null;
        $this->images = null;
        $this->category_id = null;
        $this->product_for = null;
        $this->setImg = null;
        $this->initProductFor = false;
        $this->loadingSku = false;
    }

    public function generateSkuProduct($value = null) {
        $this->loadingSku = true;
        if($value){
            if($this->initProductFor){
                if($value == "sku"){
                    $for = $this->product_for == "i" ? "IMP" : "EXP";
                    $code = strtoupper(Str::random(6));
                    $this->sku = $for . "-" . Carbon::now()->timestamp . "-" . $code;
                    return;
                }

                $arrayCode = explode("-", $this->sku);
                $arrayCode[0] = $this->product_for == "i" ? "IMP" : "EXP";
                $this->sku = implode("-", $arrayCode);
            }
            $this->initProductFor = true;
        }else{
            $this->sku = null;
            $this->initProductFor = false;
        }
        $this->loadingSku = false;
    }

    public function storeProductToDb() {
        $this->validate([
            'name' => 'required',
            'product_for' => 'required',
            'regular_price' => 'required',
            'quantity' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $imgProduct = new ImageProduct;
        $uniqImage = Carbon::now()->timestamp;
        $imageName = $uniqImage . '.' . $this->image->extension();
        $imgProduct->image = $imageName;

        $allNameImages = array_map(function ($item) {
            return Carbon::now()->timestamp. '.' . $item->extension();;
        }, $this->images);
        $jsonImages = json_encode($allNameImages);

        $imgProduct->images = $jsonImages;
        $imgProduct->folder_name = $uniqImage;
        $imgProduct->save();

        $product = new Product;
        $product->name = $this->name;
        $product->short_desc = $this->short_desc;
        $product->description = $this->description;
        $product->regular_price = $this->regular_price ? HalperFunctions::currencyToNumber($this->regular_price) : null;
        $product->sale_price = $this->sale_price ? HalperFunctions::currencyToNumber($this->sale_price) : null;
        $product->sku = $this->sku;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;
        $product->product_for = $this->product_for;
        $product->category_id = $this->category_id;
        $product->image_id = $imgProduct->id;
        
        $this->image->storeAs(HalperFunctions::colName('pr'), $imageName);
        for ($i = 0; $i < count($allNameImages); $i++) {
            $this->images[$i]->storeAs(HalperFunctions::colName('pr') . $uniqImage, $allNameImages[$i]);
        }

        $product->save();

        $this->dispatchBrowserEvent('close-form-modal');

        session()->flash('msgAlert', 'Category telah berhasil dihapus');
        session()->flash('msgStatus', 'Success');
    }

    public function loadAddData() {
        $allCategory = Category::all();
        $allProduct = Product::all();
        return [
            'allProduct' => $allProduct,
            'allCategory' => $allCategory,
        ];
    }

    public function render()
    {
        return view('livewire.admin.product-component', $this->loadAddData())->layout('layouts.admin');
    }
}
