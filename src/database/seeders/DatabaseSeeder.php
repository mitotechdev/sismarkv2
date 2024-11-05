<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Approval;
use App\Models\Tax;
use App\Models\TypeCustomer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        TypeCustomer::create([
            'name' => 'New customer',
            'tag_front_end' => 'info',
            'tag_status' => 'new',
        ]);
        TypeCustomer::create([
            'name' => 'Prospect',
            'tag_front_end' => 'warning',
            'tag_status' => 'prospect',
        ]);
        TypeCustomer::create([
            'name' => 'Existing customer',
            'tag_front_end' => 'success',
            'tag_status' => 'existing',
        ]);

        Tax::create([
            'name' => 'PPN 11%',
            'tax' => 0.11
        ]);
        Tax::create([
            'name' => 'PPN 12%',
            'tax' => 0.12
        ]);

        Approval::create([
            'name' => 'Draft',
            'tag_front_end' => 'warning',
            'tag_status' => 'draft',
        ]);

        Approval::create([
            'name' => 'Request',
            'tag_front_end' => 'info',
            'tag_status' => 'request',
        ]);

        Approval::create([
            'name' => 'Approved',
            'tag_front_end' => 'success',
            'tag_status' => 'approved',
        ]);

        Approval::create([
            'name' => 'Reject',
            'tag_front_end' => 'danger',
            'tag_status' => 'reject',
        ]);

        $this->call([
            MarketProgressSeeder::class,
            BranchSeeder::class,
            CategoryCustomerSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
