<?php

namespace Database\Seeders;

use App\Models\CategoryProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryProduct::create([
            'name' => 'General Chemical',
            'description' => 'Kategori untuk bahan kimia umum yang digunakan di industri',
        ]);

        CategoryProduct::create([
            'name' => 'Specialty Chemical',
            'description' => 'Kategori untuk bahan kimia yang diracik khusus untuk kebutuhan industri',
        ]);

        CategoryProduct::create([
            'name' => 'Equipment',
            'description' => 'Kategori untuk peralatan - peralatan yang digunakan di industri',
        ]);

        CategoryProduct::create([
            'name' => 'Lainnya',
            'description' => 'Kategori untuk spesifikasi yang tidak dapat diklasifikasikan secara khusus',
        ]);
    }
}
