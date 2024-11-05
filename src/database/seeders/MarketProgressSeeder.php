<?php

namespace Database\Seeders;

use App\Models\MarketProgress;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MarketProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MarketProgress::create(['name' => 'Mapping', 'status' => 'Prospect']);
        MarketProgress::create(['name' => 'Introduction', 'status' => 'Prospect']);
        MarketProgress::create(['name' => 'Penetration', 'status' => 'Prospect']);
        MarketProgress::create(['name' => 'Jartest', 'status' => 'Prospect']);
        MarketProgress::create(['name' => 'Penawaran', 'status' => 'Hot Prospect']);
        MarketProgress::create(['name' => 'Negosiasi', 'status' => 'Hot Prospect']);
        MarketProgress::create(['name' => 'Deal', 'status' => 'Hot Prospect']);
        MarketProgress::create(['name' => 'Purchase Order', 'status' => 'Hot Prospect']);
        MarketProgress::create(['name' => 'Loss Prospect', 'status' => 'Loss Prospect']);
    }
}
