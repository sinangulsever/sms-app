<?php

namespace Database\Seeders;

use App\Models\Customer;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Customer::create([
            'identity' => Str::random(10),
            'name' => 'Test Customer',
            'email' => Factory::create()->email,
            'phone' => Factory::create()->phoneNumber,
            'tax_no' => '1234567890',
            'tax_office' => 'Test Office',
            'address' => 'Test Address',
        ]);
    }
}
