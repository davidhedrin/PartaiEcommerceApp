<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LoginComponent extends Component
{
    public $loginOrRegis = true;

    public function changeLoginOrRegis(){
        $this->loginOrRegis = !$this->loginOrRegis;
    }

    public function render()
    {
        return view('livewire.login-component')->layout('layouts.base');
    }
}
