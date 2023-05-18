<?php

namespace App\Http\Halpers;
use App\Models\LogError;
use Exception;

class HalperFunctions{
    public static function insertLogError($submit_by, $action, $method_name, $msg_error)
    {
        $log_error = new LogError;
        $log_error->submit_by = $submit_by;
        $log_error->action = $action;
        $log_error->method_name = $method_name;
        $log_error->msg_error = $msg_error;
        $log_error->save();
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
}