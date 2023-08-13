<?php

namespace App\Http\Halpers;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Exception;

use App\Models\LogError;
use App\Models\Whitelist;

class HalperFunctions{
    public static $desiredPermissions = 0755;
    public static function desiredPermissions($imagePath){
        if (file_exists($imagePath)) {
            // $folderPermissions = fileperms($imagePath);
            // $octalPermissions = substr(sprintf('%o', $folderPermissions), -4);
            chmod($imagePath, 0755);
        }
    }
    
    public static function colName($key){
        $allCollName = [
            'ct' => 'img_category/',
            'pr' => 'img_product/',
            'vc' => 'img_voucher/',
            'tes' => 'testing_folder/',
            'ecom_set' => 'ecom_setting.txt',
        ];
        
        return $allCollName[$key] ?? null;
    }

    public static function insertLogError($submit_by, $action, $method_name, $msg_error)
    {
        $log_error = new LogError;
        $log_error->submit_by = $submit_by;
        $log_error->action = $action;
        $log_error->method_name = $method_name;
        $log_error->msg_error = $msg_error;
        $log_error->save();

        return $log_error->id;
    }
    
    public static function getTraceException(Exception $traceExc){
        $result = "";
        
        try{
            $result .= "Line: ".$traceExc->getTrace()[0]["args"][3]." - ";
            $result .= "Trace: ".$traceExc->getTrace()[0]["args"][2];
        }
        catch(Exception $ex){
        }

        return $result;
    }

    public static function currencyIDR($value) {
        $result = "Rp. " . number_format($value, 0, '.' . '.');
        return $result;
    }

    public static function currencyToNumber($value){
        $result = preg_replace('/\D/', '', $value);
        return $result;
    }

    public static function generateOtpCode(int $digit){
        $min = pow(10, $digit - 1);
        $max = pow(10, $digit) - 1;
        
        $otpCode = random_int($min, $max);
        return $otpCode;
    }

    public static function generateRandomCode(int $length, $lower = false)
    {
        $lowerChar = 'abcdefghijklmnopqrstuvwxyz';
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters .= $lower ? $lowerChar : "";
        $code = '';
        
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $code;
    }

    public static function mailDataOtp(){
        $auth = Auth::user();
        $setOtp = HalperFunctions::generateOtpCode(6);
        $dateNow = Carbon::parse(now());
        $formattedDate = $dateNow->format('d F Y');

        $mailData = [
            "email" => $auth->email,
            "subject" => "OTP Verification",
            "otp_code" => $setOtp,
            "valid_date" => $formattedDate,
        ];

        return $mailData;
    }

    public static function addRemoveWhitelist($productId, $action){
        HalperFunctions::SaveWithTransaction(
            function() use($productId, $action) {
                $auth = Auth::user();
                $findWhitelist = Whitelist::where("user_id", $auth->id)->where("product_id", $productId)->first();
                if($findWhitelist){
                    $findWhitelist->flag_active = $action;
                    $findWhitelist->save();
                }else{
                    $whitelist = new Whitelist;
                    $whitelist->user_id = $auth->id;
                    $whitelist->product_id = $productId;
                    $whitelist->save();
                }
            },
            "addProductToWhitelist"
        );

        $string = $action ? "ditambahkan ke" : "dihapus dari";
        session()->flash('msgAlert', 'Product telah berhasil ' . $string . ' whitelist');
        session()->flash('msgStatus', 'Success');
    }

    public static function filterWhitelistProduct($listProduct){
        $auth = Auth::user();
        $setListProduct = $listProduct;
        if($auth){
            $setListProduct->each(function ($product) use($auth) {
                $findInWhitelist = Whitelist::where("user_id", $auth->id)->where("product_id", $product->id)->first();
                $product->whitelist = false;
                if($findInWhitelist){
                    $product->whitelist = (bool)$findInWhitelist->flag_active;
                }
            });
        }

        return $setListProduct;
    }

    public static function HitRateLimit($throttleKey, $limit, $timeMinute){
        if(RateLimiter::tooManyAttempts($throttleKey, $limit)){
            $seconds  = RateLimiter::availableIn($throttleKey, $timeMinute * 60);
            $displayMinutes = ceil($seconds / 60);
            session()->flash('msgAlert', "Maaf, percobaan telah melewati batas! Coba lagi dalam waktu $displayMinutes menit.");
            session()->flash('msgStatus', 'Warning');
            return false;
        }
        
        RateLimiter::hit($throttleKey);
        return true;
    }

    public static function SaveWithTransaction(\Closure $trans, $function = null, $eventName = null) {
        try {
            DB::beginTransaction();
            
            $trans();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            $error_msg = $e->getMessage();
            $stackTrace = HalperFunctions::getTraceException($e);
            $insertError = HalperFunctions::insertLogError(
                Auth::check() ? Auth::user()->email : "UNKNOWN_USER", 
                $function ? $function : "UNKNOWN_FUNCTION", 
                "POST", 
                $error_msg." | ".$stackTrace
            );
    
            // if ($eventName) {
            //     event(new \App\Events\BrowserEvent($eventName));
            // }
            session()->flash('msgAlert', 'Data gagal disimpan! Error ID: ' . $insertError);
            session()->flash('msgStatus', 'Danger');

            return;
        }
    }
}