<?php

namespace App\Http\Livewire;

use Livewire\Component;

class OrderedTransctions extends Component
{
    public function render()
    {
        return view('livewire.ordered-transctions')->layout('layouts.base');
    }
}
