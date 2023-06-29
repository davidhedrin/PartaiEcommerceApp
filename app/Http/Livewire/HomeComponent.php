<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Product;
use App\Models\ImageProduct;
use App\Models\Category;
use Livewire\WithPagination;

class HomeComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function loadAllData() {
        $allProductImport = Product::where('product_for', 'i')->paginate();
        $allProductExport = Product::where('product_for', 'e')->paginate(8);

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
