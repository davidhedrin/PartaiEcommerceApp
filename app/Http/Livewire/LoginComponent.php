<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class LoginComponent extends Component
{
    public $loginOrRegis = true;
    public $emailLogin, $passwordLogin;
    public $name, $email, $no_ponsel, $password, $co_password, $alamat;

    public function updated($fields){
        $this->validateOnly($fields, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
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

        try{
            $user = User::where('email', $this->emailLogin)->first();
            $throttleKey = $this->emailLogin;

            if(RateLimiter::tooManyAttempts($throttleKey, 3)){
                $seconds  = RateLimiter::availableIn($throttleKey);
                // session()->flash('msgAlert', 'Maaf, percobaan login telah melewati batas! Coba lagi dalam waktu '.$seconds);
                // session()->flash('msgStatus', 'warning');
                return;
            }
            
            RateLimiter::hit($throttleKey);

            if($user){
                if(Hash::check($this->password, $user->password)){
                    $getUserAuth = Auth::attempt(['email' => $this->emailLogin, 'password' => $this->passwordLogin]);
                    if($getUserAuth){
                        if(strtolower($user->flag_active) === "y"){
                            if(strtolower($user->user_type) === "adm"){
                                return redirect()->route('adm-dashboard');
                            }else{
                                return redirect()->route('home');
                            }
                        }else{
                            // session()->flash('msgAlert', 'Ops... Akun anda telah di Non-aktifkan, Hubungi admin. Terimakasih!');
                            // session()->flash('msgStatus', 'warning');
                        }
                    }else{
                        // session()->flash('msgAlert', 'Opss.., Telah terjadi kesalahan, mohon tunggu beberapa saat lagi!');
                        // session()->flash('msgStatus', 'warning');
                    }
                }else{
                    // session()->flash('msgAlert', 'Maaf, password yang anda masukkan tidak sesuai!');
                    // session()->flash('msgStatus', 'warning');
                }
            }else{
                // session()->flash('msgAlert', 'Maaf, email atau password yang anda masukkan tidak terdaftar!');
                // session()->flash('msgStatus', 'warning');
            }
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError($this->email, "loginUser", "GET", $error_msg." | ".$stackTrace);
            // session()->flash('msgAlert', 'Telah terjadi kesalahan pada sistem. Mohon tunggu atau hubungi Admin, dan Coba beberapa saat lagi. Terimakasih!');
            // session()->flash('msgStatus', 'warning');
        }
    }

    public function addRegisterData(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users.email',
            'no_ponsel' => 'required|numeric|digits_between:11,12',
            'password' => 'required|min:6|required_with:co_password',
            'co_password' => 'required|min:6|required_with:password|same:password',
            'alamat' => 'required'
        ]);

        try{
            $throttleKey = request()->ip();
            if(RateLimiter::tooManyAttempts($throttleKey, 3)){
                $seconds  = RateLimiter::availableIn($throttleKey);
                // session()->flash('msgAlert', 'Maaf, percobaan mendaftar telah melewati batas '.$seconds);
                // session()->flash('msgStatus', 'warning');
                return;
            }
            
            RateLimiter::hit($throttleKey);

            $passHash = Hash::make($this->password);
            $user = new User;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = $passHash;
            $user->no_ponsel = $this->no_ponsel;
            $user->user_type = "USR";
            $user->alamat = $this->alamat;
            $user->save();

            // session()->flash('msgAlert', 'Perndaftaran telah berhasil, silahkan login dan selamat bergabung. Terimakasih');
            // session()->flash('msgStatus', 'success');
            $this->resetFormAdd();
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError("Registere's", "addRegisterData", "POST", $error_msg." | ".$stackTrace);
            // session()->flash('msgAlert', 'Telah terjadi kesalahan pada sistem. Mohon tunggu atau hubungi Admin, dan Coba beberapa saat lagi. Terimakasih!');
            // session()->flash('msgStatus', 'warning');
        }
    }

    public function render()
    {
        return view('livewire.login-component')->layout('layouts.base');
    }
}
