<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Country;
use App\Models\AddressUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AccountSettingComponent extends Component
{
    public $fullName, $phoneNumber;
    public $gender, $birth_place, $birth_date, $country_id;
    public $oldPassword, $newPassword, $confirmNewPassword;
    public $activeSetting = 1;

    public $address_fname, $address_lname, $address_contact, $address_address, $address_city, $address_country, $address_post_code, $address_mark_as;

    public function updated($fields){
        $auth = Auth::user();

        $rules = [
            // "fullName" => "required",
            // "phoneNumber" => "required|numeric|digits_between:1,12",

            // "oldPassword" => "required",
            // "newPassword" => "required",
            // "confirmNewPassword" => "required",
            "address_fname" => "required",
            "address_lname" => "required",
            "address_contact" => "required|numeric|digits_between:1,12",
            "address_address" => "required",
            "address_city" => "required",
            "address_country" => "required",
            "address_post_code" => "required",
        ];

        // if(trim($this->phoneNumber) != trim($auth->no_ponsel)){
        //     $rules['phoneNumber'] .= '|' . Rule::unique('users', 'no_ponsel');
        // }

        $this->validateOnly($fields, $rules);
    }

    public function mount($activeId = null){
        $this->allDataProfile();

        if($activeId){
            $this->activeSetting = $activeId;
        }
    }

    public function allDataProfile(){
        $user = Auth::user();
        $userDetail = UserDetail::where("user_id", $user->id)->first();

        $this->fullName = $user->name;
        $this->phoneNumber = $user->no_ponsel;

        $this->gender = $userDetail->gender ?? null;
        $this->birth_place = $userDetail->birth_place ?? null;
        $this->birth_date = $userDetail->birth_date ?? null;
        $this->country_id = $userDetail->country_id ?? null;
    }

    public function changeActiveSetting($id){
        $this->activeSetting = $id;

        if($id == 1){
            $this->allDataProfile();
        }
    }

    public function resetFormAddress(){
        $this->address_fname = null;
        $this->address_lname = null;
        $this->address_contact = null;
        $this->address_address = null;
        $this->address_city = null;
        $this->address_country = null;
        $this->address_post_code = null;
        $this->address_mark_as = null;
    }

    public function saveUserDetail(){
        $throttleKey = request()->ip() . "saveUserDetail";
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 5, 1);
        if (!$rateLimitNotExceeded) return;

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
                    $findDetail->country_id = $this->country_id;
                    $findDetail->save();
                }else{
                    $saveDetail = new UserDetail;
                    $saveDetail->user_id = $auth->id;
                    $saveDetail->gender = $this->gender;
                    $saveDetail->birth_place = $this->birth_place;
                    $saveDetail->birth_date = $this->birth_date;
                    $saveDetail->country_id = $this->country_id;
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

    public function saveChangePassword(){
        $throttleKey = request()->ip() . "saveChangePassword";
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 3, 1);
        if (!$rateLimitNotExceeded) return;

        $this->validate([
            "oldPassword" => "required",
            "newPassword" => "required|min:6|required_with:confirmNewPassword",
            "confirmNewPassword" => "required|min:6|required_with:password|same:newPassword",
        ]);

        $user = Auth::user();
        try{
            $findUser = User::find($user->id);
            if($findUser){
                if(Hash::check($this->oldPassword, $findUser->password)){
                    $findUser->password = Hash::make($this->newPassword);
                    $findUser->save();

                    session()->flash('msgAlert', 'Password has been successfully changed. Please try again to log in.');
                    session()->flash('msgStatus', 'Success');
                    return redirect()->route('logout');
                }else{
                    session()->flash('msgAlert', 'Failed to change password! Old password does not match.');
                    session()->flash('msgStatus', 'Warning');
                }
            }else{
                session()->flash('msgAlert', 'Credential is not invalid! Please try to login again.');
                session()->flash('msgStatus', 'Warning');

                return redirect()->route('logout');
            }
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError( $user->email, "saveChangePassword", "POST", $error_msg." | ".$stackTrace);

            session()->flash('msgAlert', 'Something went wrong! Please try again in a moment.');
            session()->flash('msgStatus', 'Danger');
        }
    }

    public function saveNewAddress(){
        $throttleKey = request()->ip() . "saveNewAddress";
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 3, 1);
        if (!$rateLimitNotExceeded) return;

        $this->validate([
            "address_fname" => "required",
            "address_lname" => "required",
            "address_contact" => "required|numeric|digits_between:1,12",
            "address_address" => "required",
            "address_city" => "required",
            "address_country" => "required",
            "address_post_code" => "required",
        ]);

        HalperFunctions::SaveWithTransaction(
            function() {
                $user = Auth::user();
                if($this->address_mark_as){
                    $findAddress = AddressUser::where("user_id", $user->id)->where("mark_as", $this->address_mark_as)->first();
                    if($findAddress){
                        $findAddress->mark_as = null;
                        $findAddress->save();
                    }
                }

        
                $fullName = trim($this->address_fname) . " " .trim($this->address_lname);
                $newAddress = new AddressUser;
                $newAddress->user_id = $user->id;
                $newAddress->name = $fullName;
                $newAddress->contact = $this->address_contact;
                $newAddress->address = $this->address_address;
                $newAddress->city = $this->address_city;
                $newAddress->country = $this->address_country;
                $newAddress->post_code = $this->address_post_code;
                $newAddress->mark_as = $this->address_mark_as;
                $newAddress->save();
        
                $this->resetFormAddress();
                $this->dispatchBrowserEvent('close-form-modal');
                session()->flash('msgAlert', 'The new address has been added successfully.');
                session()->flash('msgStatus', 'Success');
            },
            "saveNewAddress"
        );
    }

    public $idDeleteAddress;
    public function deleteAddress(){
        if($this->idDeleteAddress){
            $findAddress = AddressUser::find($this->idDeleteAddress);
            if($findAddress){
                $findAddress->delete();
                
                $this->idDeleteAddress = null;
                $this->dispatchBrowserEvent('close-form-modal');
                session()->flash('msgAlert', 'Successful deletion, address data has been successfully deleted.');
                session()->flash('msgStatus', 'Success');
            }else{
                session()->flash('msgAlert', 'Delete failed, address data not found!');
                session()->flash('msgStatus', 'Warning');
            }
        }
    }

    public function loadAddData(){
        $user = Auth::user();
        $allNational = Country::all();
        $allAddress = AddressUser::where("user_id", $user->id)->get();

        return [
            "user" => $user,
            "countries" => $allNational,
            "allAddress" => $allAddress,
        ];
    }

    public function render()
    {
        return view('livewire.account-setting-component', $this->loadAddData())->layout('layouts.base');
    }
}
