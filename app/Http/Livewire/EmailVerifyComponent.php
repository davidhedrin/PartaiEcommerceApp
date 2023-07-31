<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\RateLimiter;

class EmailVerifyComponent extends Component
{
    public function sendEmailVerify()
    {
        $this->dispatchBrowserEvent('action-loading', ['actionFor' => true]);
        $user = Auth::user();
        $throttleKey = $user->email .request()->ip() . "sendEmailVerify";

        try{
            event(new Registered($user));
            $rateLimitNotExceeded = HalperFunctions::HitRateLimit($throttleKey, 3, 1);
            if (!$rateLimitNotExceeded) return;

            $this->dispatchBrowserEvent('action-loading', ['actionFor' => false]);
            session()->flash('msgAlert', 'Verifikasi Email berhasil dikirim! Periksa email anda dan verifikasi email.');
            session()->flash('msgStatus', 'Success');
        }catch(Exception $e){
            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            HalperFunctions::insertLogError($user->email, "sendEmailVerify", "POST", $error_msg." | ".$stackTrace);

            $this->dispatchBrowserEvent('action-loading', ['actionFor' => false]);
            session()->flash('msgAlert', 'Telah terjadi kesalahan pada sistem. Mohon tunggu atau hubungi Admin, dan Coba beberapa saat lagi. Terimakasih!');
            session()->flash('msgStatus', 'Warning');
        }
    }

    public function render()
    {
        return view('livewire.email-verify-component')->layout('layouts.base');
    }
}
