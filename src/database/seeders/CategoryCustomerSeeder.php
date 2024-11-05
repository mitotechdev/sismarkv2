<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryCustomer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoryCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryCustomer::create(['name' => 'Hotel']);
        CategoryCustomer::create(['name' => 'Kolam Renang']);
        CategoryCustomer::create(['name' => 'Pabrik']);
        CategoryCustomer::create(['name' => 'PDAM']);
        CategoryCustomer::create(['name' => 'PKS']);
        CategoryCustomer::create(['name' => 'Rumah Sakit']);
        CategoryCustomer::create(['name' => 'Supplier']);
    }
}
