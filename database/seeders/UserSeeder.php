<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()
        //     ->count(1)
        //     ->create();

        User::create([
            'name' => 'JC Andres',
            'email' => 'jcsandres9@gmail.com',
            'username' => 'superuser',
            'password' => 'password123', // password123
            'remember_token' => Str::random(10)
        ]);
    }
}
