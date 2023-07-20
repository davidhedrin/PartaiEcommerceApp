<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Halpers\HalperFunctions;
use Exception;

use Illuminate\Support\Facades\Mail;

class OtpVerfyComponent extends Component
{
    public function sendMailOtp(){
        $auth = Auth::user();

        $mailData = [
            "email" => "davidhedrin123@gmail.com",
            "subject" => "OTP Verification",
            "otp_code" => "123456",
        ];

        Mail::send('layouts.email-template', $mailData, function ($message) use($mailData, $auth) {
            $message->to($mailData["email"], $auth->name);
            $message->subject($mailData["subject"]);
        });

        session()->flash('msgAlert', 'Kode OTP baru telah berhasil dikirim! Masukkan kode dalam waktu 1 menit.');
        session()->flash('msgStatus', 'Success');
    }

    public function render()
    {
        return view('livewire.admin.otp-verfy-component')->layout('layouts.base');
    }
}
