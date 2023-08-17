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
    function formatDate($id, $value, $time = false)
    {
        $result = null;

        if($id == "in"){
            $result = $time ? Carbon::parse($value)->format('d/m/Y H:i') : Carbon::parse($value)->format('d/m/Y');
        }

        return $result;
    }
}

if (!function_exists('formatDateFormal')){
    function formatDateFormal($value, $time = false)
    {
        $result = $value;

        $carbonDate = Carbon::parse($value);
        $formattedDate = $time ? $carbonDate->format('d F Y H:i') : $carbonDate->format('d F Y');
        $indonesianMonths = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        $result = str_replace(array_keys($indonesianMonths), array_values($indonesianMonths), $formattedDate);

        return $result;
    }
}

if (!function_exists('totalCheckoutProduct')){
    function totalCheckoutProduct($products)
    {
        $result = 0;

        foreach($products as $product){
            $result += $product->sale ? $product->sale * $product->qty : $product->price * $product->qty;
        }

        return $result;
    }
}

if (!function_exists('transactionWithVoucher')){
    function transactionWithVoucher($getTotal, $getVoucher = null)
    {
        $result = 0;

        if($getVoucher){
            if($getVoucher->type == "fixed"){ // Voucher fixed
                $result = $getVoucher->value;
            }else{ // Voucher discount
                $percent = ($getVoucher->value / 100);
                $calculateDiscount = $getTotal * $percent;
                $totalDiscount = $getVoucher->max_value_percent ? ($calculateDiscount > $getVoucher->max_value_percent ? $getVoucher->max_value_percent : $calculateDiscount) : $calculateDiscount;
                $result = $totalDiscount;
            }
        }

        return $result;
    }
}