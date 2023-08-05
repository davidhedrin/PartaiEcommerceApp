<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\UserDetail;

class AccountProfileComponent extends Component
{
    public $fullName, $phoneNumber;
    public $gender, $birth_place, $birth_date, $nationality, $religion;

    public function mount(){
        $user = Auth::user();

        $this->fullName = $user->name;
        $this->phoneNumber = $user->no_ponsel;
    }

    // public function updated($fields){
    //     $this->validateOnly($fields, [
    //         "gender" => "required",
    //         "birth_place" => "required",
    //         "birth_date" => "required",
    //         "nationality" => "required",
    //         "religion" => "required",
    //     ]);
    // }

    public function saveUserDetail(){
        $this->validate([
            "gender" => "required",
            "birth_place" => "required",
            "birth_date" => "required",
            "nationality" => "required",
            "religion" => "required",
        ]);

        HalperFunctions::SaveWithTransaction(
            function() {
                $auth = Auth::user();

                $findDetail = UserDetail::where("user_id")->first();
                if($findDetail){

                }else{
                    
                }
                
                session()->flash('msgAlert', 'Detail profile telah berhasil diperbaharui');
                session()->flash('msgStatus', 'Success');
            },
            "saveUserDetail"
        );
    }

    public function loadAddData(){
        $user = Auth::user();

        return [
            "user" => $user,
        ];
    }

    public function render()
    {
        return view('livewire.account-profile-component', $this->loadAddData())->layout('layouts.base');
    }
}
