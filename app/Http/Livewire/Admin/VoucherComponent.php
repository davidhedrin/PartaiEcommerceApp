<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

class VoucherComponent extends Component
{
    public $code, $type, $value, $max_value_percent, $exp_date, $keterangan;
    public $product_discont, $min_cart, $for_product;

    public function updated($fields){
        $this->validateOnly($fields, [
            'code' => 'required',
        ]);
    }

    public function reselFormValue(){
        $this->code = null;
        $this->type = null;
        $this->value = null;
        $this->max_value_percent = null;
        $this->exp_date = null;
        $this->keterangan = null;
        $this->product_discont = null;
        $this->min_cart = null;
        $this->for_product = null;
    }

    public function render()
    {
        return view('livewire.admin.voucher-component')->layout('layouts.admin');
    }
}
