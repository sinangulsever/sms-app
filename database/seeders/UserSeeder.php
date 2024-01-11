<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'customer_id' => Customer::first()->id,
            'name' => 'Test User',
            'email' => 'sinan@gmail.com',
            'password' => bcrypt('1233'),
        ]);
    }
}
