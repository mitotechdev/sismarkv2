<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'code' => 'PKU',
            'name' => 'HO Pekanbaru',
            'npwp' => '96.007.415.1-216.000',
            'phone' => '0761 5795004',
            'address' => 'Jl. Riau, Gg Harapan 2, Pekanbaru, Riau',
            'pic' => 'Taufan'
        ]);
        Branch::create([
            'code' => 'MDN',
            'name' => 'Cabang Medan',
            'npwp' => '96.007.415.1-216.000',
            'phone' => '0761 5795004',
            'address' => 'Jl. Riau, Gg Harapan 2, Pekanbaru, Riau',
            'pic' => 'Hafiz'
        ]);
        Branch::create([
            'code' => 'PNK',
            'name' => 'Cabang Pontianak',
            'npwp' => '96.007.415.1-216.000',
            'phone' => '0761 5795004',
            'address' => 'Jl. Riau, Gg Harapan 2, Pekanbaru, Riau',
            'pic' => 'Saktiar Sitorus'
        ]);
    }
}
