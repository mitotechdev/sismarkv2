<?php

namespace Database\Seeders;

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
            'employee_id' => '-',
            'branch_id' => 1,
            'name' => 'MITO',
            'username' => 'mito',
            'gender' => 'Pria',
            'phone' => '081234567890',
            'email' => 'qKoX9@example.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'employee_id' => '-',
            'branch_id' => 1,
            'name' => 'Bayu Buana',
            'username' => 'bayu',
            'gender' => 'Pria',
            'phone' => '081234567890',
            'email' => 'bayu@example.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'employee_id' => '-',
            'branch_id' => 1,
            'name' => 'Yudha Satria',
            'username' => 'yudha',
            'gender' => 'Pria',
            'phone' => '081234567890',
            'email' => 'yudha@example.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'employee_id' => '-',
            'branch_id' => 1,
            'name' => 'Jefri Ariandi',
            'username' => 'jefry',
            'gender' => 'Pria',
            'phone' => '081234567890',
            'email' => 'jefri@example.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'employee_id' => '-',
            'branch_id' => 1,
            'name' => 'Sintia Lestari',
            'username' => 'sintia',
            'gender' => 'Perempuan',
            'phone' => '081234567890',
            'email' => 'sintia@example.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
