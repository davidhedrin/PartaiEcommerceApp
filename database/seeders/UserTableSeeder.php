<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'davidhedrin123@gmail.com';
        $findAdmin = User::where('email', $email)->first();
        if ($findAdmin) {
            $findAdmin->delete();
        }
        $passHash = Hash::make('david123');
        User::create([
            'name' => 'Admin Ecommerce',
            'email' => $email,
            'no_ponsel' => '082110863133',
            'password' => $passHash,
            'user_type' => 1, //1 As admin
            'flag_active' => 'Y',
            'alamat' => 'Admin ecommerce app laravel',
            'email_verified_at' => now(),
        ]);
    }
}
