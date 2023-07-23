<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Whitelist;

class WhitelistCounter extends Component
{
    public $total = 0;
    protected $listeners = ['updateWhitelistCount' => 'getWhitelistCount'];

    public function getWhitelistCount(){
        $this->total = Whitelist::where('user_id', Auth::user()->id)->where('flag_active', true)->count();
    }

    public function render()
    {
        $this->getWhitelistCount();
        return view('livewire.component.whitelist-counter');
    }
}
