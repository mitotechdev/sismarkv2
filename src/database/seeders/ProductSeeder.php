<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'code' => "RB500",
            'name' => 'Rojen B 500 (Oxygen Scavenger / Catalys Sulfhite)',
            'packaging' => '25 Kg/Pail',
            'unit' => 'Kg',
            'category' => 'Specialty Chemical',
        ]);

        Product::create([
            'code' => "RB1533",
            'name' => 'Rojen B 1533 (Polymer Phospate)',
            'packaging' => '30 Kg/Cans',
            'unit' => 'Kg',
            'category' => 'Specialty Chemical',
        ]);

        Product::create([
            'code' => "RB2032",
            'name' => 'Rojen B 2032 (Dispersant)',
            'packaging' => '30 Kg/Cans',
            'unit' => 'Kg',
            'category' => 'Specialty Chemical',
        ]);

        Product::create([
            'code' => "ALUM.G.TR",
            'name' => 'Aluminium Sulfate Grannular, Timur Raya',
            'packaging' => '50 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "ALUM.P.TR",
            'name' => 'Aluminium Sulfate Powder, Timur Raya',
            'packaging' => '50 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "ALUM.B.TR",
            'name' => 'Aluminium Sulfate Batu, Timur Raya',
            'packaging' => '50 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "ANI.F",
            'name' => 'Anionic Flocullant',
            'packaging' => '25 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "CAT.F",
            'name' => 'Cationic Flacullant',
            'packaging' => '25 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "CSF.CHINA",
            'name' => 'Caustic Soda Flake, china',
            'packaging' => '25 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "CSF.INDIA",
            'name' => 'Caustic Soda Flake, India',
            'packaging' => '25 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "TCCA.90.G",
            'name' => 'TCCA 90% Granular',
            'packaging' => '50 Kg/Drum',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "TCCA.90.P",
            'name' => 'TCCA 90% Powder',
            'packaging' => '50 Kg/Drum',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "TCCA.90.T",
            'name' => 'TCCA 90% Tablet',
            'packaging' => '15 Kg/Drum',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "KAPORIT.65",
            'name' => 'Kaporit 65%',
            'packaging' => '15 Kg/Pail',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "KAPORIT.70",
            'name' => 'Kaporit 70%',
            'packaging' => '15 Kg/Pail',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "KAPORIT.T.60",
            'name' => 'Kaporit Tjiwi 60%',
            'packaging' => '15 Kg/Pail',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        
        Product::create([
            'code' => "N.HEXANE",
            'name' => 'N Hexane',
            'packaging' => '200 Liter/Drum',
            'unit' => 'Liter',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "PAC.MW.RRT",
            'name' => 'PAC Milky White/Dancow, RRT',
            'packaging' => '20 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "PAC.YL",
            'name' => 'PAC Yellow Light',
            'packaging' => '25 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "PAC.DG",
            'name' => 'PAC DG',
            'packaging' => '25 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "SAL.RRT",
            'name' => 'Soda Ash Light, RRT',
            'packaging' => '40 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "SAD.99",
            'name' => 'Soda Ash Danse 99%',
            'packaging' => '50 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "GARAM",
            'name' => 'Garam',
            'packaging' => '50 Kg/Zak',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "HCL",
            'name' => 'HCL',
            'packaging' => '250 Kg/Drum',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
        Product::create([
            'code' => "SOD.HYP",
            'name' => 'Sodium Hypochlorite',
            'packaging' => '250 Kg/Drum',
            'unit' => 'Kg',
            'category' => 'General Chemical',
        ]);
    }
}
