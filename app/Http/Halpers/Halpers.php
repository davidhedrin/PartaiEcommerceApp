<?php

if (!function_exists('colName')){
    function colName($key)
    {
        $allCollName = [
            'ct' => 'img_category/',
            'pr' => 'img_product/',
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