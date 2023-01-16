<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
            'user_id' => 1,
            'name' => 'Cash',
            'initial_amount' => 0
        ]);

        Account::create([
            'user_id' => 1,
            'name' => 'Card',
            'initial_amount' => 0
        ]);

        Account::create([
            'user_id' => 1,
            'name' => 'Savings',
            'initial_amount' => 0
        ]);
    }
}
