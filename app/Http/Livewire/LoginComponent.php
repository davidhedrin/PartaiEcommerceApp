<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginComponent extends Component
{
    public $loginOrRegis = true;
    public $emailLogin, $passwordLogin;
    public $name, $email, $no_ponsel, $password, $co_password, $alamat;

    public function updated($fields){
        $this->validateOnly($fields, [
            'name' => 'required',
            'email' => 'required|email',
            'no_ponsel' => 'required|numeric|digits_between:11,12',
            'password' => 'required|min:6|required_with:co_password',
            'co_password' => 'required|min:6|required_with:password|same:password',
            'alamat' => 'required',
            
            'emailLogin' => 'required|email',
            'passwordLogin' => 'required|min:6'
        ]);
    }

    public function resetFormAdd(){
        $this->loginOrRegis = true;
        $this->name = null;
        $this->email = null;
        $this->no_ponsel = null;
        $this->password = null;
        $this->co_password = null;
        $this->alamat = null;
    }

    public function changeLoginOrRegis(){
        $this->loginOrRegis = !$this->loginOrRegis;
    }

    public function loginUser(){
        $this->validate([
            'emailLogin' => 'required|email',
            'passwordLogin' => 'required|min:6'
        ]);

        dd(123);
    }

    public function addRegisterData(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_ponsel' => 'required|numeric|digits_between:11,12',
            'password' => 'required|min:6|required_with:co_password',
            'co_password' => 'required|min:6|required_with:password|same:password',
            'alamat' => 'required'
        ]);

        try{
            $passHash = Hash::make($this->password);
            $user = new User;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = $passHash;
            $user->no_ponsel = $this->no_ponsel;
            $user->alamat = $this->alamat;
            $user->save();

            $this->resetFormAdd();
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError("Registere's", "addRegisterData", "POST", $error_msg." | ".$stackTrace);
            // session()->flash('msgExcLogin', 'Telah terjadi kesalahan pada sistem. Mohon tunggu atau hubungi Admin, dan Coba beberapa saat lagi. Terimakasih!');
        }
    }

    public function render()
    {
        return view('livewire.login-component')->layout('layouts.base');
    }
}
