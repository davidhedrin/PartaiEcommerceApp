<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Product;
use App\Models\ImageProduct;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $name, $image, $short_desc, $description, $regular_price, $sale_price;
    public $sku, $featured = false, $quantity, $images = [], $category_id, $product_for, $exp_date;
    public $initProductFor =  false, $initProductBtn = false, $loadingSku = false, $setImg, $setImgEdit;
    public $imageEdit, $imageEditView, $imagesEdit = [], $imagesEditView = [], $imagesEditMap = [];
    public $folderName, $countShowProduct = 5;
    public $model_image_id = "image_id", $model_image = "image";

    public function updated($fields) {
        $this->validateOnly($fields, [
            'name' => 'required',
            'product_for' => 'required',
            'description' => 'required',
            'image' => 'required',
            'sku' => 'required',
        ]);
        
        if($this->setImg){
            $this->images[] = [
                $this->model_image_id => Str::random(10),
                $this->model_image => $this->setImg
            ];
            $this->setImg = null;
        }
        if($this->setImgEdit){
            $this->imagesEdit[] = [
                $this->model_image_id => Str::random(10),
                $this->model_image => $this->setImgEdit
            ];
            $this->setImgEdit = null;
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
        $this->exp_date = null;
        $this->setImg = null;
        $this->initProductFor = false;
        $this->initProductBtn = false;
        $this->loadingSku = false;

        $this->imageEdit = null;
        $this->imagesEdit = null;
        $this->imageEditView = null;
        $this->imagesEditView = null;
        $this->imagesEditMap = null;
        $this->setImgEdit = null;
        $this->folderName = null;
    }

    public function generateSkuProduct($value = null) {
        $this->loadingSku = true;
        if($value){
            if($this->initProductFor){
                if($value == "sku"){
                    $for = $this->product_for == "i" ? "IMP" : "EXP";
                    $code = strtoupper(Str::random(6));
                    $this->sku = $for . "-" . Carbon::now()->timestamp . "-" . $code;
                    $this->initProductBtn = true;
                    return;
                }

                if($this->initProductBtn){
                    $arrayCode = explode("-", $this->sku);
                    $arrayCode[0] = $this->product_for == "i" ? "IMP" : "EXP";
                    $this->sku = implode("-", $arrayCode);
                }
            }
            $this->initProductFor = true;
        }else{
            $this->sku = null;
            $this->initProductFor = false;
            $this->initProductBtn = false;
        }
        $this->loadingSku = false;
    }

    public function storeProductToDb($action = true) {
        $this->validate([
            'name' => 'required',
            'product_for' => 'required',
            'description' => 'required',
            'image' => 'required',
            'sku' => 'required',
        ]);

        HalperFunctions::SaveWithTransaction(
            function() use($action) {
                $imgProduct = new ImageProduct;
                $uniqImage = Carbon::now()->timestamp . Str::random(6);
                $imageName = $uniqImage . '.' . $this->image->extension();
                $imgProduct->image = $imageName;
                $allNameImages = [];
                if(!empty($this->images)){
                    $allNameImages = array_map(function ($item) {
                        return Carbon::now()->timestamp . Str::random(6) . '.' . $item[$this->model_image]->extension();
                    }, $this->images);
                }
                $jsonImages = json_encode($allNameImages);
                $imgProduct->images = $jsonImages;
                $imgProduct->folder_name = $uniqImage;
                $imgProduct->created_by = Auth::user()->email;
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
                $product->stock_status = $this->quantity > 0;
                $product->product_for = $this->product_for;
                $product->category_id = $this->category_id;
                $product->image_id = $imgProduct->id;
                $product->created_by = Auth::user()->email;
                $product->exp_date = $this->exp_date;
                
                $product->save();

                $checkCurrentPath = storage_path('app/'. HalperFunctions::colName('pr'));
                $existCurrentPath = file_exists($checkCurrentPath);
                $this->image->storeAs(HalperFunctions::colName('pr'), $imageName);
                if (!$existCurrentPath){
                    HalperFunctions::desiredPermissions($checkCurrentPath);
                }
                if(!empty($this->images)){
                    for ($i = 0; $i < count($allNameImages); $i++) {
                        $setImg = $this->images[$i];
                        $setImg[$this->model_image]->storeAs(HalperFunctions::colName('pr') . $uniqImage, $allNameImages[$i]);
                    }
                    $imagePath = storage_path('app/'. HalperFunctions::colName('pr') . $uniqImage);
                    HalperFunctions::desiredPermissions($imagePath);
                }
        
                if($action){
                    $this->dispatchBrowserEvent('close-form-modal');
                }
                session()->flash('msgAlert', 'Product telah berhasil ditambahkan');
                session()->flash('msgStatus', 'Success');
            },
            'storeProductToDb'
        );

        $this->reselFormValue();
    }

    public $idForUpdate;
    public function openModelForEdit($id) {
        $this->idForUpdate = $id;
        $this->initProductFor = true;
        $this->initProductBtn = true;

        $product = Product::find($id);
        $this->name = $product->name;
        $this->imageEditView = $product->image->image;
        $this->short_desc = $product->short_desc;
        $this->description = $product->description;
        $this->regular_price = $product->regular_price ? intval($product->regular_price) : null;
        $this->sale_price = $product->sale_price ? intval($product->sale_price) : null;
        $this->sku = $product->sku;
        $this->quantity = $product->quantity;
        $this->imagesEditView = json_decode($product->image->images, true);
        $this->category_id = $product->category_id;
        $this->product_for = $product->product_for;
        $this->featured = $product->featured;
        $this->folderName = $product->image->folder_name;
        $this->exp_date = $product->exp_date;

        $this->imagesEditMap = collect($this->imagesEditView)->map(function ($item) {
            $result = [
                $this->model_image_id => Str::random(10),
                $this->model_image => $item
            ];
            return $result;
        });
        
        $this->dispatchBrowserEvent('open-form-modal');
    }

    public function delViewImagesEdit($id) {
        $filteredImages = $this->imagesEditMap->filter(function ($image) use ($id) {
            return $image[$this->model_image_id] !== $id;
        });
        
        $this->imagesEditMap = collect($filteredImages)->map(function ($item) {
            return $item;
        });
    }

    public function delImages($id, $delete_for){
        if($delete_for === 1){
            $this->images = collect($this->images)->filter(function ($image) use ($id) {
                if($image[$this->model_image_id] === $id){
                    Storage::delete("livewire-tmp/" . $image[$this->model_image]->getFilename());
                }
                return $image[$this->model_image_id] !== $id;
            })->values()->all();
        }
        else if($delete_for === 2){
            $this->imagesEdit = collect($this->imagesEdit)->filter(function ($image) use ($id) {
                if($image[$this->model_image_id] === $id){
                    Storage::delete("livewire-tmp/" . $image[$this->model_image]->getFilename());
                }
                return $image[$this->model_image_id] !== $id;
            })->values()->all();
        }
    }

    public function saveUpdateProdut($id) {
        $this->validate([
            'name' => 'required',
            'product_for' => 'required',
            'description' => 'required',
            'imageEditView' => 'required',
            'sku' => 'required',
        ]);
        HalperFunctions::SaveWithTransaction(
            function () use ($id) {
                $product = Product::find($id);
                $imgProduct = ImageProduct::find($product->image_id);

                $allNameImages = collect($this->imagesEditMap)->map(function ($img){
                    return $img[$this->model_image];
                });
                $nameImages = [];
                if(!empty($this->imagesEdit)){
                    foreach($this->imagesEdit as $img){
                        $nameImg = Carbon::now()->timestamp . Str::random(6) . '.' . $img[$this->model_image]->extension();
                        $allNameImages[] = $nameImg;
                        $nameImages[] = $nameImg;
                    }
                }
                
                $jsonImages = json_encode($allNameImages);
                $imgProduct->images = $jsonImages;
                $imgProduct->updated_by = Auth::user()->email;
                $imgProduct->save();

                $product->name = $this->name;
                $product->short_desc = $this->short_desc;
                $product->description = $this->description;
                $product->regular_price = $this->regular_price ? HalperFunctions::currencyToNumber($this->regular_price) : null;
                $product->sale_price = $this->sale_price ? HalperFunctions::currencyToNumber($this->sale_price) : null;
                $product->sku = $this->sku;
                $product->featured = $this->featured;
                $product->quantity = $this->quantity;
                $product->stock_status = $this->quantity > 0;
                $product->product_for = $this->product_for;
                $product->category_id = $this->category_id;
                $product->updated_by = Auth::user()->email;
                $product->exp_date = $this->exp_date;
                $product->save();

                $currentImages = collect($this->imagesEditMap)->map(function ($img){
                    return $img[$this->model_image];
                })->values()->all();
                $getAllImages = storage_path('app/'. HalperFunctions::colName('pr') . $imgProduct->folder_name);
                if (is_dir($getAllImages)) {
                    $files = File::allFiles($getAllImages);
                    $allImages = collect($files)->map(function ($file){
                        return $file->getFilename();
                    })->values()->all();
    
                    $resultImages = array_diff($allImages, $currentImages);
    
                    foreach($resultImages as $img){
                        Storage::delete(HalperFunctions::colName('pr') . $imgProduct->folder_name . '/' . $img);
                    }
                }
                
                if($this->imageEdit){
                    $this->imageEdit->storeAs(HalperFunctions::colName('pr'), $imgProduct->image);
                }
                if(!empty($this->imagesEdit)){
                    for ($i = 0; $i < count($nameImages); $i++) {
                        $setImg = $this->imagesEdit[$i];
                        $setImg[$this->model_image]->storeAs(HalperFunctions::colName('pr') . $imgProduct->folder_name, $nameImages[$i]);
                    }
                }
                
                $this->dispatchBrowserEvent('close-form-modal');
                session()->flash('msgAlert', 'Product telah berhasil diperbaharui');
                session()->flash('msgStatus', 'Success');
            },
            'saveUpdateProdut'
        );
    }

    public $idForDelete;
    public function openModelForDelete($id) {
        $this->idForDelete = null;
        $this->idForDelete = $id;
    }

    public function activeInActiveProduct($id, $action) {
        $flag_active = $action == 1 ? false : true;
        HalperFunctions::SaveWithTransaction(
            function () use ($id, $flag_active){
                $product = Product::find($id);
                $image = ImageProduct::find($product->image_id);
    
                $image->flag_active = $flag_active;
                $product->flag_active = $flag_active;
                $image->save();
                $product->save();

                $this->dispatchBrowserEvent('close-form-modal');
                $status = $flag_active ? 'Aktifkan' : 'NonAktifkan';
                session()->flash('msgAlert', 'Product telah berhasil di ' . $status);
                session()->flash('msgStatus', 'Success');
            },
            'confirmDeleteProduct',
            'close-form-modal'
        );
    }

    public function loadAddData() {
        $allCategory = Category::all();
        $allProduct = Product::orderBy('created_at', 'desc')->paginate($this->countShowProduct);
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
