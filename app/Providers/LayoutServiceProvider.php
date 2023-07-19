<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use App\Http\Halpers\HalperFunctions;

class LayoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('layouts.base', function ($view) {
            $data_json = (object)[];
    
            $filePath = HalperFunctions::colName('ecom_set');
            if (Storage::exists($filePath)) {
                $content = Storage::get($filePath);
                if (!empty($content)) {
                    $datas = explode(PHP_EOL, $content);
                    $data_json = json_decode($datas[0], false);
                }
            }
    
            $view->with([
                'email' => $data_json->email ?? null,
                'contact' => $data_json->contact ?? null,
                'address' => $data_json->address ?? null,
                'sosmed' => $data_json->sosmed ?? null,
            ]);
        });
    }
}
