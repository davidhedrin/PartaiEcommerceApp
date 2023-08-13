<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Transaction;

class OrderedCounter extends Component
{
    public $total = 0;
    protected $listeners = ['updateOrderedCount' => 'getOrderedItemCount'];
    
    public function getOrderedItemCount(){
        $this->total = Transaction::where('user_id', Auth::user()->id)->count();
    }

    public function render()
    {
        $this->getOrderedItemCount();
        return view('livewire.component.ordered-counter');
    }
}
