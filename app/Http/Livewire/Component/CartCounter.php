<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\ShopingCart;

class CartCounter extends Component
{
    public $total = 0;
    protected $listeners = ['updateCartCount' => 'getCartItemCount'];
    
    public function getCartItemCount(){
        $this->total = ShopingCart::where('user_id', Auth::user()->id)->count();
    }

    public function render()
    {
        $this->getCartItemCount();
        return view('livewire.component.cart-counter');
    }
}
