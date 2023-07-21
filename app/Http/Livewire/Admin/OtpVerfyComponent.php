<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Halpers\HalperFunctions;
use Exception;

use App\Models\OtpVerify;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class OtpVerfyComponent extends Component
{
    public $codeOtp;
    
    public function mount(){
        if(!empty(session('admin_otp'))){
            return redirect()->route('logout');
        }
    }

    public function updated($fields){
        $this->validateOnly($fields, [
            'codeOtp' => 'numeric|digits:6',
        ]);
    }

    public function sendMailOtp(){
        HalperFunctions::SaveWithTransaction(
            function() {
                $auth = Auth::user();
                $findOtp = OtpVerify::where("user_id", $auth->id)->first();
                $mailData = HalperFunctions::mailDataOtp();

                if($findOtp){
                    $updated_at = $findOtp->updated_at;
                    if(!$updated_at->isAfter(now()->startOfDay())){
                        Mail::send('layouts.email-template', $mailData, function ($message) use($mailData, $auth) {
                            $message->to($mailData["email"], $auth->name);
                            $message->subject($mailData["subject"]);
                        });

                        $findOtp->otp = $mailData["otp_code"];
                        $findOtp->save();

                        session()->flash('msgAlert', 'Kode OTP baru telah berhasil dikirim! Masukkan kode dalam waktu 1 menit.');
                        session()->flash('msgStatus', 'Success');
                    }else{
                        session()->flash('msgAlert', 'Gagal mengirim OTP! Akses kode OTP untuk hari ini sudah dimuat, Silahkan perikas email anda.');
                        session()->flash('msgStatus', 'Info');
                    }
                }else{
                    Mail::send('layouts.email-template', $mailData, function ($message) use($mailData, $auth) {
                        $message->to($mailData["email"], $auth->name);
                        $message->subject($mailData["subject"]);
                    });
    
                    $saveOtp = new OtpVerify;
                    $saveOtp->user_id = $auth->id;
                    $saveOtp->otp = $mailData["otp_code"];
                    $saveOtp->save();
                
                    session()->flash('msgAlert', 'Kode OTP baru telah berhasil dikirim! Masukkan kode dalam waktu 1 menit.');
                    session()->flash('msgStatus', 'Success');
                }
            },
            "sendMailOtp"
        );
    }

    public function confirmCheckOtp(){
        $this->validate([
            'codeOtp' => 'required|numeric|digits:6',
        ]);

        $auth = Auth::user();
        $findOtp = OtpVerify::where("user_id", $auth->id)->first();
        if($findOtp){
            if($findOtp->otp == $this->codeOtp){
                session()->put('admin_otp', $this->codeOtp);
                return redirect()->route('adm-dashboard');
            }else{
                session()->flash('msgAlert', 'Gagal memverifikasi kode! Akses kode OTP tidak sesuai.');
                session()->flash('msgStatus', 'Info');
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.otp-verfy-component')->layout('layouts.base');
    }
}
