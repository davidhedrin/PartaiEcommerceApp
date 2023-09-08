<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\StatusTransaction;

class StatusTransactionProvider extends ServiceProvider
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
        // $enumStatusTrans = StatusTransaction::all()->map(function ($item) {
        //     return (object) [
        //         'id' => $item->id,
        //         'name' => $item->name,
        //         'badge' => $item->badge,
        //         'code' => $item->code,
        //     ];
        // })->toArray();
        // view()->share('enumStatusTrans', $enumStatusTrans);
    }
}
