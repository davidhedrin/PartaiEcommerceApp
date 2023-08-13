<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tableName = (new PaymentMethod)->getTable();
        if (Schema::hasTable($tableName)) {
            $rowCount = PaymentMethod::count();
            if ($rowCount > 0) {
                PaymentMethod::truncate();
            }
            DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $payment_method = [
            [
                "name" => "GoPay",
                "code" => "po-001-gojek",
                "type" => 1,
                "img" => "icon-gopay.png",
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank BNI",
                "code" => "po-002-bni",
                "type" => 1,
                "img" => "icon-bni.png",
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank BRI",
                "code" => "po-003-bri",
                "type" => 1,
                "img" => "icon-bri.png",
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank CIMB Niaga",
                "code" => "po-004-gojek",
                "type" => 1,
                "img" => "icon-cimbniaga.png",
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank Mandiri",
                "code" => "po-005-mandiri",
                "type" => 1,
                "img" => "icon-mandiri.png",
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank Permata",
                "code" => "po-006-permata",
                "type" => 1,
                "img" => "icon-permata.png",
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Debit Card",
                "code" => "po-007-debit",
                "type" => 2,
                "img" => null,
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];

        PaymentMethod::insert($payment_method);
    }
}
