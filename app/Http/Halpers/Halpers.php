<?php
use Carbon\Carbon;

if (!function_exists('colName')){
    function colName($key)
    {
        $allCollName = [
            'ct' => 'img_category/',
            'pr' => 'img_product/',
            'vc' => 'img_voucher/',
        ];
        
        return $allCollName[$key] ?? null;
    }
}

if (!function_exists('currency_IDR')){
    function currency_IDR($value)
    {
        return "Rp. " . number_format($value, 0, '.' . '.');
    }
}

if (!function_exists('currencyIDRToNumeric')){
    function currencyIDRToNumeric($value)
    {
        return preg_replace('/\D/', '', $value);
    }
}

if (!function_exists('formatDate')){
    function formatDate($id, $value)
    {
        $result = $value;

        if($id == "in"){
            $result = Carbon::parse($value)->format('d/m/Y');
        }

        return $result;
    }
}