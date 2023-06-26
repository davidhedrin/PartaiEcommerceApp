<?php

namespace App\Http\Halpers;
use App\Models\LogError;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class HalperFunctions{
    public static function colName($key){
        $allCollName = [
            'ct' => 'img_category/',
            'pr' => 'img_product/',
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