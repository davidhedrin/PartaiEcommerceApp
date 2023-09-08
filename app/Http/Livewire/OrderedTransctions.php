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
    public $mountAllTransaction, $activePage = 1;

    public function mount($activeId = null){
        $this->activePage = $activeId ? $activeId : 1;

        $auth = Auth::user();
        $this->mountAllTransaction = Transaction::where("user_id", $auth->id)->get();
    }

    public function loadAllData(){
        $allTransaction = $this->mountAllTransaction->where("status_id", $this->activePage)->all();

        return[
            "allTransaction" => $allTransaction,
        ];
    }

    public function render()
    {
        return view('livewire.ordered-transctions', $this->loadAllData())->layout('layouts.base');
    }
}
