<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Halpers\HalperFunctions;
use Exception;

class LogoutComponent extends Component
{
    public function hitLogout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }

    public function render()
    {
        $this->hitLogout();
        return view('livewire.logout-component');
    }
}
