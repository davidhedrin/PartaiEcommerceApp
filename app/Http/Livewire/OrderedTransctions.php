<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\CheckoutProduct;
use App\Models\Transaction;

class OrderedTransctions extends Component
{
    public $activePage = 1;

    public function loadAllData(){
        $auth = Auth::user();
        $allTransaction = Transaction::where("user_id", $auth->id)->get();

        return[
            "allTransaction" => $allTransaction,
        ];
    }

    public function render()
    {
        return view('livewire.ordered-transctions', $this->loadAllData())->layout('layouts.base');
    }
}
