<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jenis Produk
        Permission::create(['name' => 'create-type-product', 'slug' => 'Create', 'for_menu' => 'Jenis Produk']);
        Permission::create(['name' => 'read-type-product', 'slug' => 'Read', 'for_menu' => 'Jenis Produk']);
        Permission::create(['name' => 'edit-type-product', 'slug' => 'Edit', 'for_menu' => 'Jenis Produk']);
        Permission::create(['name' => 'delete-type-product', 'slug' => 'Delete', 'for_menu' => 'Jenis Produk']);
        
        // Kategori Produk
        Permission::create(['name' => 'create-category-product', 'slug' => 'Create', 'for_menu' => 'Kategori Produk']);
        Permission::create(['name' => 'read-category-product', 'slug' => 'Read', 'for_menu' => 'Kategori Produk']);
        Permission::create(['name' => 'edit-category-product', 'slug' => 'Edit', 'for_menu' => 'Kategori Produk']);
        Permission::create(['name' => 'delete-category-product', 'slug' => 'Delete', 'for_menu' => 'Kategori Produk']);

        // Segmen Customer
        Permission::create(['name' => 'create-segment-customer', 'slug' => 'Create', 'for_menu' => 'Segmen Customer']);
        Permission::create(['name' => 'read-segment-customer', 'slug' => 'Read', 'for_menu' => 'Segmen Customer']);
        Permission::create(['name' => 'edit-segment-customer', 'slug' => 'Edit', 'for_menu' => 'Segmen Customer']);
        Permission::create(['name' => 'delete-segment-customer', 'slug' => 'Delete', 'for_menu' => 'Segmen Customer']);
        
        // Pajak
        Permission::create(['name' => 'create-tax', 'slug' => 'Create', 'for_menu' => 'Pajak']);
        Permission::create(['name' => 'read-tax', 'slug' => 'Read', 'for_menu' => 'Pajak']);
        Permission::create(['name' => 'edit-tax', 'slug' => 'Edit', 'for_menu' => 'Pajak']);
        Permission::create(['name' => 'delete-tax', 'slug' => 'Delete', 'for_menu' => 'Pajak']);

        //Market Progress
        Permission::create(['name' => 'create-market-progress', 'slug' => 'Create', 'for_menu' => 'Market Progress']);
        Permission::create(['name' => 'read-market-progress', 'slug' => 'Read', 'for_menu' => 'Market Progress']);
        Permission::create(['name' => 'edit-market-progress', 'slug' => 'Edit', 'for_menu' => 'Market Progress']);
        Permission::create(['name' => 'delete-market-progress', 'slug' => 'Delete', 'for_menu' => 'Market Progress']);
        
        // Produk
        Permission::create(['name' => 'create-product', 'slug' => 'Create', 'for_menu' => 'Produk']);
        Permission::create(['name' => 'read-product', 'slug' => 'Read', 'for_menu' => 'Produk']);
        Permission::create(['name' => 'edit-product', 'slug' => 'Edit', 'for_menu' => 'Produk']);
        Permission::create(['name' => 'delete-product', 'slug' => 'Delete', 'for_menu' => 'Produk']);

        // Branch
        Permission::create(['name' => 'create-branch', 'slug' => 'Create', 'for_menu' => 'Branch']);
        Permission::create(['name' => 'read-branch', 'slug' => 'Read', 'for_menu' => 'Branch']);
        Permission::create(['name' => 'edit-branch', 'slug' => 'Edit', 'for_menu' => 'Branch']);
        Permission::create(['name' => 'delete-branch', 'slug' => 'Delete', 'for_menu' => 'Branch']);

        // Customer
        Permission::create(['name' => 'create-customer', 'slug' => 'Create', 'for_menu' => 'Customer']);
        Permission::create(['name' => 'read-customer', 'slug' => 'Read', 'for_menu' => 'Customer']);
        Permission::create(['name' => 'edit-customer', 'slug' => 'Edit', 'for_menu' => 'Customer']);
        Permission::create(['name' => 'delete-customer', 'slug' => 'Delete', 'for_menu' => 'Customer']);

        // Realisasi Kerja
        Permission::create(['name' => 'create-realisasi-kerja', 'slug' => 'Create', 'for_menu' => 'Realisasi Kerja']);
        Permission::create(['name' => 'read-realisasi-kerja', 'slug' => 'Read', 'for_menu' => 'Realisasi Kerja']);
        Permission::create(['name' => 'edit-realisasi-kerja', 'slug' => 'Edit', 'for_menu' => 'Realisasi Kerja']);
        Permission::create(['name' => 'delete-realisasi-kerja', 'slug' => 'Delete', 'for_menu' => 'Realisasi Kerja']);
        Permission::create(['name' => 'create-progress', 'slug' => 'Create Progress', 'for_menu' => 'Realisasi Kerja']);
        Permission::create(['name' => 'edit-progress', 'slug' => 'Edit Progress', 'for_menu' => 'Realisasi Kerja']);
        Permission::create(['name' => 'delete-progress', 'slug' => 'Delete Progress', 'for_menu' => 'Realisasi Kerja']); 

        // Purchase order
        Permission::create(['name' => 'create-purchase-order', 'slug' => 'Create', 'for_menu' => 'Purchase Order']);
        Permission::create(['name' => 'read-purchase-order', 'slug' => 'Read', 'for_menu' => 'Purchase Order']);
        Permission::create(['name' => 'edit-purchase-order', 'slug' => 'Edit', 'for_menu' => 'Purchase Order']);
        Permission::create(['name' => 'delete-purchase-order', 'slug' => 'Delete', 'for_menu' => 'Purchase Order']);
        Permission::create(['name' => 'approve-purchase-order', 'slug' => 'Approve PO', 'for_menu' => 'Purchase Order']);
        Permission::create(['name' => 'create-item-purchase-order', 'slug' => 'Create item', 'for_menu' => 'Purchase Order']);
        Permission::create(['name' => 'edit-item-purchase-order', 'slug' => 'Edit item', 'for_menu' => 'Purchase Order']);
        Permission::create(['name' => 'delete-item-purchase-order', 'slug' => 'Delete item', 'for_menu' => 'Purchase Order']);
        Permission::create(['name' => 'submit-item-purchase-order', 'slug' => 'Submit item', 'for_menu' => 'Purchase Order']);
        
        // Recap Invoice
        Permission::create(['name' => 'create-recap-invoice', 'slug' => 'Create', 'for_menu' => 'Recap Invoice']);
        Permission::create(['name' => 'read-recap-invoice', 'slug' => 'Read', 'for_menu' => 'Recap Invoice']);
        Permission::create(['name' => 'edit-recap-invoice', 'slug' => 'Edit', 'for_menu' => 'Recap Invoice']);
        Permission::create(['name' => 'delete-recap-invoice', 'slug' => 'Delete', 'for_menu' => 'Recap Invoice']);
        
        // User
        Permission::create(['name' => 'create-user', 'slug' => 'Create', 'for_menu' => 'User']);
        Permission::create(['name' => 'read-user', 'slug' => 'Read', 'for_menu' => 'User']);
        Permission::create(['name' => 'edit-user', 'slug' => 'Edit', 'for_menu' => 'User']);
        Permission::create(['name' => 'delete-user', 'slug' => 'Delete', 'for_menu' => 'User']);
        
        // Admin Accesibility
        Permission::create(['name' => 'admin-view', 'slug' => 'Admin View', 'for_menu' => 'Admin Accesibility']);
        Permission::create(['name' => 'admin-switch-branch', 'slug' => 'Switch Branch', 'for_menu' => 'Admin Accesibility']);
        Permission::create(['name' => 'pull-report-progress', 'slug' => 'Pull Report Progress', 'for_menu' => 'Admin Accesibility']);
        Permission::create(['name' => 'pull-report-po', 'slug' => 'Pull Report PO', 'for_menu' => 'Admin Accesibility']);
        Permission::create(['name' => 'pull-report-payment', 'slug' => 'Pull Report Payment', 'for_menu' => 'Admin Accesibility']);
        Permission::create(['name' => 'dashboard-view', 'slug' => 'Dashboard View', 'for_menu' => 'Admin Accesibility']);
        Permission::create(['name' => 'report-view', 'slug' => 'Report View', 'for_menu' => 'Admin Accesibility']);
    }
}
