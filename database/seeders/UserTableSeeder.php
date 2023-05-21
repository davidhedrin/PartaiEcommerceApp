<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passHash = Hash::make('admin123');
        //User::truncate();
        User::create([
            'name' => 'David Simbolon',
            'email' => 'admin123@gmail.com',
            'no_ponsel' => '082110863133',
            'password' => $passHash,
            'user_type' => 1, //1 As admin
            'flag_active' => 'Y',
            'alamat' => 'Admin ecommerce app laravel',
        ]);
    }
}
