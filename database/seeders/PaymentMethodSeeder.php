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
                "code" => "po-001",
                "type" => 1,
                "payment_type" => "gopay",
                "bank_transfer" => null,
                "img" => "icon-gopay.png",
                "fee_fixed" => null,
                "fee_percent" => 2,
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank BNI",
                "code" => "po-002",
                "type" => 1,
                "payment_type" => "bank_transfer",
                "bank_transfer" => "bni",
                "img" => "icon-bni.png",
                "fee_fixed" => 4000,
                "fee_percent" => null,
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank BRI",
                "code" => "po-003",
                "type" => 1,
                "payment_type" => "bank_transfer",
                "bank_transfer" => "bri",
                "img" => "icon-bri.png",
                "fee_fixed" => 4000,
                "fee_percent" => null,
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank CIMB Niaga",
                "code" => "po-004",
                "type" => 1,
                "payment_type" => "bank_transfer",
                "bank_transfer" => "cimb",
                "img" => "icon-cimbniaga.png",
                "fee_fixed" => 4000,
                "fee_percent" => null,
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank Mandiri",
                "code" => "po-005",
                "type" => 1,
                "payment_type" => "echannel",
                "bank_transfer" => null,
                "img" => "icon-mandiri.png",
                "fee_fixed" => 4000,
                "fee_percent" => null,
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Bank Permata",
                "code" => "po-006",
                "type" => 1,
                "payment_type" => "permata",
                "bank_transfer" => null,
                "img" => "icon-permata.png",
                "fee_fixed" => 4000,
                "fee_percent" => null,
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name" => "Debit Card",
                "code" => "po-007",
                "type" => 2,
                "payment_type" => "credit_card",
                "bank_transfer" => null,
                "img" => null,
                "fee_fixed" => 2000,
                "fee_percent" => 2.9,
                "flag_active" => true,
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];

        PaymentMethod::insert($payment_method);
    }
}
