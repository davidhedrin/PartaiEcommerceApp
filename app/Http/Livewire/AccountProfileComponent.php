<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Validation\Rule;

class AccountProfileComponent extends Component
{
    public $fullName, $phoneNumber;
    public $gender, $birth_place, $birth_date, $nationality, $religion;

    public function updated($fields){
        $auth = Auth::user();

        $rules = [
            "fullName" => "required",
            "phoneNumber" => "required|numeric|digits_between:1,12"
        ];

        if(trim($this->phoneNumber) != trim($auth->no_ponsel)){
            $rules['phoneNumber'] .= '|' . Rule::unique('users', 'no_ponsel');
        }

        $this->validateOnly($fields, $rules);
    }

    public function mount(){
        $user = Auth::user();
        $userDetail = UserDetail::find($user->id);

        $this->fullName = $user->name;
        $this->phoneNumber = $user->no_ponsel;

        $this->gender = $userDetail->gender ?? null;
        $this->birth_place = $userDetail->birth_place ?? null;
        $this->birth_date = $userDetail->birth_date ?? null;
        $this->nationality = $userDetail->nationality ?? null;
        $this->religion = $userDetail->religion ?? null;
    }

    public function saveUserDetail(){
        $rules = [
            "fullName" => "required",
            "phoneNumber" => "required|numeric|digits_between:1,12",
        ];
        
        if(trim(Auth::user()->no_ponsel) != trim($this->phoneNumber)){
            $rules['phoneNumber'] .= '|' . Rule::unique('users', 'no_ponsel');
        }

        $this->validate($rules);

        HalperFunctions::SaveWithTransaction(
            function() {
                $auth = Auth::user();

                $findDetail = UserDetail::where("user_id", $auth->id)->first();
                if($findDetail){
                    $findDetail->gender = $this->gender;
                    $findDetail->birth_place = $this->birth_place;
                    $findDetail->birth_date = $this->birth_date;
                    $findDetail->nationality = $this->nationality;
                    $findDetail->religion = $this->religion;
                    $findDetail->save();
                }else{
                    $saveDetail = new UserDetail;
                    $saveDetail->user_id = $auth->id;
                    $saveDetail->gender = $this->gender;
                    $saveDetail->birth_place = $this->birth_place;
                    $saveDetail->birth_date = $this->birth_date;
                    $saveDetail->nationality = $this->nationality;
                    $saveDetail->religion = $this->religion;
                    $saveDetail->save();
                }

                if(trim($auth->name) != trim($this->fullName) || trim($auth->no_ponsel) != trim($this->phoneNumber)){
                    $findUser = User::find($auth->id);
                    $findUser->name = trim($this->fullName);
                    $findUser->no_ponsel = trim($this->phoneNumber);
                    $findUser->save();
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
