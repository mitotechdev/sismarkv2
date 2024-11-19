<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin =User::create([
            'branch_id' => 1,
            'name' => 'Super Admin',
            'username' => 'admin',
            'gender' => 'Pria',
            'phone' => '-',
            'email' => 'it@mit;oindonesia.com',
            'password' => Hash::make('admin123'),
            'status' => 1, // define for super admin
        ]);
        $superAdmin->assignRole('Super Admin');
        
        User::create([
            'branch_id' => 1,
            'name' => 'MITO',
            'username' => 'mito',
            'gender' => 'Pria',
            'phone' => '081234567890',
            'email' => 'office@mitoindonesia.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'branch_id' => 1,
            'name' => 'Eko Susilo',
            'username' => 'ekosusilo',
            'gender' => 'Pria',
            'phone' => '081234567890',
            'email' => 'reiko@mitoindonesia.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'branch_id' => 1,
            'name' => 'Yudha Satria',
            'username' => 'yudha',
            'gender' => 'Pria',
            'phone' => '081234567890',
            'email' => 'yudhasatria@mitoindonesia.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'branch_id' => 1,
            'name' => 'Jefri Ariandi',
            'username' => 'jefry',
            'gender' => 'Pria',
            'phone' => '081234567890',
            'email' => 'jefri@mitoindonesia.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'branch_id' => 1,
            'name' => 'Sintia Lestari',
            'username' => 'sintia',
            'gender' => 'Perempuan',
            'phone' => '081234567890',
            'email' => 'sintia@mitoindonesia.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
