<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tableName = (new Country)->getTable();
        if (Schema::hasTable($tableName)) {
            $rowCount = Country::count();
            if ($rowCount > 0) {
                Country::truncate();
            }
            DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $apiUrl = "https://restcountries.com/v2/all";
        $response = file_get_contents($apiUrl);

        $countries = [];
        if ($response !== false) {
            $countriesData = json_decode($response, true);

            foreach ($countriesData as $country) {
                $countries[] = [
                    "name" => $country["name"],
                    "sortname" => $country["alpha3Code"],
                    "code" => $country["numericCode"],
                    "phone_code" => $country["callingCodes"][0],
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            }
        }

        Country::insert($countries);
    }
}
