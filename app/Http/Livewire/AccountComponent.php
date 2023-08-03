<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AccountComponent extends Component
{
    public function render()
    {
        return view('livewire.account-component')->layout('layouts.base');
    }
}
