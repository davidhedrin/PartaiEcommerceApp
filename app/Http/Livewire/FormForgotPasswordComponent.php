<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\RateLimiter;

class FormForgotPasswordComponent extends Component
{
    public $token, $email;
    public $newPassword, $coNewPassword;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'newPassword' => 'required',
            'coNewPassword' => 'required|same:newPassword',
        ]);
    }

    public function mount(Request $request)
    {
        if(!$request->token && !$request->email){
            return redirect()->route('login');
        }

        $this->token = $request->token;
        $this->email = $request->email;
    }
    
    public function saveNewPassword(){
        $this->validate([
            'newPassword' => 'required',
            'coNewPassword' => 'required|same:newPassword',
        ]);

        $throttleKey = $this->email . request()->ip() . "saveNewPassword";
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 3, 1);
        if (!$rateLimitNotExceeded) return;
        
        try{
            $user = User::where('email', $this->email)->first();
            if($user){
                $user->password = Hash::make($this->newPassword);
                $user->remember_token = $this->token;
                $user->save();
                
                event(new PasswordReset($user));
                session()->flash('msgAlert', 'Atur ulang kata sandi telah berhasil, Silahkan lakukan login');
                session()->flash('msgStatus', 'success');
                return redirect()->route('login');
            }else{
                session()->flash('msgAlert', 'Terjadi kesalahan. Gagal mengatur ulang kata sandi, dikarenakan Email sudah tidak lagi terdaftar.');
                session()->flash('msgStatus', 'info');
                return redirect()->route('login');
            }
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError($this->email, "saveNewPassword", "POST", $error_msg." | ".$stackTrace);
            session()->flash('msgAlert', 'Telah terjadi kesalahan pada sistem. Mohon tunggu atau hubungi Admin, dan Coba beberapa saat lagi. Terimakasih!');
            session()->flash('msgStatus', 'Warning');
        }
    }

    public function render()
    {
        return view('livewire.form-forgot-password-component')->layout('layouts.base');
    }
}
