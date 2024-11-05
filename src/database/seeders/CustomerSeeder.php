<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'branch_id' => 1,
            'name' => 'PT Agung Bumi Lestari',
            'category_customer_id' => 3,
            'user_id' => 5,
            'npwp' => '-',
            'owner' => '-',
            'email' => 'example@mitoindonesia.com',
            'phone_number' => '-',
            'address' => '-',
            'city' => 'Pekanbaru',
            'desc_technical' => '-',
            'desc_clasification' => '-'
        ]);
        Customer::create([
            'branch_id' => 1,
            'name' => 'PT Grand Citra Prima',
            'category_customer_id' => 5,
            'user_id' => 5,
            'npwp' => '-',
            'owner' => '-',
            'email' => 'example@mitoindonesia.com',
            'phone_number' => '-',
            'address' => '-',
            'city' => 'Pekanbaru',
            'desc_technical' => '-',
            'desc_clasification' => '-'
        ]);

        Customer::create([
            'branch_id' => 1,
            'name' => 'PDAM Tirta Indra',
            'category_customer_id' => 4,
            'user_id' => 5,
            'npwp' => '-',
            'owner' => '-',
            'email' => 'example@mitoindonesia.com',
            'phone_number' => '-',
            'address' => '-',
            'city' => 'Pekanbaru',
            'desc_technical' => '-',
            'desc_clasification' => '-'
        ]);


    }
}
