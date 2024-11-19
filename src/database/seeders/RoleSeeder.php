<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        Role::create(['name' => 'User', 'guard_name' => 'web']);
        Role::create(['name' => 'Admin Sales', 'guard_name' => 'web']);
        Role::create(['name' => 'Sales Marketing', 'guard_name' => 'web']);
        Role::create(['name' => 'Head Sales Marketing', 'guard_name' => 'web']);
        Role::create(['name' => 'Support Sales Marketing', 'guard_name' => 'web']);
        Role::create(['name' => 'Director', 'guard_name' => 'web']);
        Role::create(['name' => 'Manager', 'guard_name' => 'web']);
    }
}
