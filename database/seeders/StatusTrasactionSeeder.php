<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\StatusTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatusTrasactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tableName = (new StatusTransaction)->getTable();
        if (Schema::hasTable($tableName)) {
            $rowCount = StatusTransaction::count();
            if ($rowCount > 0) {
                StatusTransaction::truncate();
            }
            DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $items = [
            [
                "name" => "Waiting Payment",
                "badge" => "badge-secondary",
                "code" => "waiting_payment",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Paid",
                "badge" => "badge-primary",
                "code" => "paid",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Packing",
                "badge" => "badge-primary",
                "code" => "packing",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Shipment",
                "badge" => "badge-primary",
                "code" => "shipment",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Finished",
                "badge" => "badge-success",
                "code" => "finished",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Canceled",
                "badge" => "badge-warning",
                "code" => "canceled",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Expired",
                "badge" => "badge-dark",
                "code" => "expired",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];
        
        StatusTransaction::insert($items);
    }
}
