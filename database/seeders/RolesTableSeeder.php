<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $tableName = (new Role)->getTable();
        if (Schema::hasTable($tableName)) {
            $rowCount = Role::count();
            if ($rowCount > 0) {
                Role::truncate();
            }
            DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Role::create(['type' => 'admin']);
        Role::create(['type' => 'kurir']);
        Role::create(['type' => 'user']);
    }
}
