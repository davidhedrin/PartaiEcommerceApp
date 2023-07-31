<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;

class ForgotPasswordComponent extends Component
{
    public $email;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'email' => 'required|email:filter',
        ]);
    }
    
    public function sendLinkResetPass()
    {
        $this->validate([
            'email' => 'required|email:filter',
        ]);

        $throttleKey = $this->email . request()->ip() . "sendLinkResetPass";
        $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 3, 1);
        if (!$rateLimitNotExceeded) return;

        try{
            $findEmail = User::where('email', $this->email)->first();
            if($findEmail){
                Password::sendResetLink(['email' => $this->email]);
                
                session()->flash('msgAlert', 'Link telah dikirim. Perikas email untuk mengatur ulang password.');
                session()->flash('msgStatus', 'Success');
                return redirect()->route('login');
            }else{
                session()->flash('msgAlert', 'Kami tidak dapat menjangkau. Alamat email tidak ditemukan!');
                session()->flash('msgStatus', 'Warning');
            }
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError($this->email, "sendLinkResetPass", "POST", $error_msg." | ".$stackTrace);
            session()->flash('msgAlert', 'Telah terjadi kesalahan pada sistem. Mohon tunggu atau hubungi Admin, dan Coba beberapa saat lagi. Terimakasih!');
            session()->flash('msgStatus', 'Warning');
        }
    }

    public function render()
    {
        return view('livewire.forgot-password-component')->layout('layouts.base');
    }
}
