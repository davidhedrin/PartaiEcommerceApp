<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class AllOrderComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.all-order-component')->layout('layouts.admin');
    }
}
