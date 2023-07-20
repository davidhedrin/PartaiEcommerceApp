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
            'no_ponsel' => 'required|numeric|unique:users|digits_between:11,12',
            'password' => 'required|min:6|required_with:co_password',
            'co_password' => 'required|min:6|required_with:password|same:password',
            'alamat' => 'required',
            
            'emailLogin' => 'required|email',
            'passwordLogin' => 'required|min:6'
        ]);
    }

    public function resetFormAdd(){
        $this->name = null;
        $this->email = null;
        $this->no_ponsel = null;
        $this->password = null;
        $this->co_password = null;
        $this->alamat = null;
        $this->emailLogin = null;
        $this->passwordLogin = null;
    }

    public function changeLoginOrRegis(){
        $this->resetFormAdd();
        $this->loginOrRegis = !$this->loginOrRegis;
    }

    public function loginUser(){
        $this->validate([
            'emailLogin' => 'required|email',
            'passwordLogin' => 'required|min:6'
        ]);

        $this->dispatchBrowserEvent('action-loading', ['actionFor' => true]);
        try{
            $user = User::where('email', $this->emailLogin)->first();
            $throttleKey = $this->emailLogin;

            if(RateLimiter::tooManyAttempts($throttleKey, 3)){
                $seconds  = RateLimiter::availableIn($throttleKey);
                session()->flash('msgAlert', 'Maaf, percobaan login telah melewati batas! Coba lagi dalam waktu 1 Menit');
                session()->flash('msgStatus', 'Warning');
                return;
            }
            
            RateLimiter::hit($throttleKey);

            if($user){
                if(Hash::check($this->passwordLogin, $user->password)){
                    $getUserAuth = Auth::attempt(['email' => $this->emailLogin, 'password' => $this->passwordLogin]);
                    if($getUserAuth){
                        if(strtolower($user->flag_active) === "y"){
                            if($user->role->id === 1){
                                session()->put('admin_otp', '');
                                return redirect()->route('adm-dashboard');
                            }else{
                                return redirect()->route('home');
                            }
                        }else{
                            session()->flash('msgAlert', 'Ops... Akun anda telah di Non-aktifkan, Hubungi admin. Terimakasih!');
                            session()->flash('msgStatus', 'Warning');
                        }
                    }else{
                        session()->flash('msgAlert', 'Opss.., Telah terjadi kesalahan, mohon tunggu beberapa saat lagi!');
                        session()->flash('msgStatus', 'Warning');
                    }
                }else{
                    session()->flash('msgAlert', 'Maaf, password yang anda masukkan tidak sesuai!');
                    session()->flash('msgStatus', 'Warning');
                }
            }else{
                session()->flash('msgAlert', 'Maaf, email atau password yang anda masukkan tidak terdaftar!');
                session()->flash('msgStatus', 'Warning');
            }
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError($this->email, "loginUser", "GET", $error_msg." | ".$stackTrace);
            
            $this->dispatchBrowserEvent('action-loading', ['actionFor' => false]);
            session()->flash('msgAlert', 'Telah terjadi kesalahan pada sistem. Mohon tunggu atau hubungi Admin, dan Coba beberapa saat lagi. Terimakasih!');
            session()->flash('msgStatus', 'Warning');
        }
    }

    public function addRegisterData(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_ponsel' => 'required|numeric|unique:users|digits_between:11,12',
            'password' => 'required|min:6|required_with:co_password',
            'co_password' => 'required|min:6|required_with:password|same:password',
            'alamat' => 'required'
        ]);

        $this->dispatchBrowserEvent('action-loading', ['actionFor' => true]);
        try{
            $throttleKey = request()->ip();
            if(RateLimiter::tooManyAttempts($throttleKey, 3)){
                $seconds  = RateLimiter::availableIn($throttleKey);
                session()->flash('msgAlert', 'Maaf, percobaan login telah melewati batas! Coba lagi dalam waktu 1 Menit');
                session()->flash('msgStatus', 'Warning');
                return;
            }
            
            RateLimiter::hit($throttleKey);

            $passHash = Hash::make($this->password);
            $user = new User;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = $passHash;
            $user->no_ponsel = $this->no_ponsel;
            $user->alamat = $this->alamat;
            $user->save();
            
            // $this->loginOrRegis = true;
            // $this->resetFormAdd();
            // session()->flash('msgAlert', 'Perndaftaran telah berhasil, silahkan login dan selamat bergabung. Terimakasih');
            // session()->flash('msgStatus', 'Success');
            
            $getUserAuth = Auth::attempt(['email' => $this->email, 'password' => $this->password]);
            return redirect()->route('home');
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError("Registere's ".request()->ip(), "addRegisterData", "POST", $error_msg." | ".$stackTrace);
            
            $this->dispatchBrowserEvent('action-loading', ['actionFor' => false]);
            session()->flash('msgAlert', 'Telah terjadi kesalahan pada sistem. Mohon tunggu atau hubungi Admin, dan Coba beberapa saat lagi. Terimakasih!');
            session()->flash('msgStatus', 'Warning');
        }
    }

    public function render()
    {
        return view('livewire.login-component')->layout('layouts.base');
    }
}
