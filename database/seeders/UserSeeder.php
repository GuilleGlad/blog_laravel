<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'full_name' => 'Guillermo Garcia',
            'email' => 'guilleglad@gmail.com',
            'password' => Hash::make('password123'),
        ])->assignRole('Administrator');

        User::create([
            'full_name' => 'Belkis Hernandez',
            'email' => 'belxio15@gmail.com',
            'password' => Hash::make('password'),
        ])->assignRole('Author');

        User::factory(10)->create();
    }
}
