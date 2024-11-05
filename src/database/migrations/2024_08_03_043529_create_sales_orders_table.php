<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('no_sales_order')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('segmen_id')->nullable()->constrained('category_customers')->nullOnDelete();
            $table->foreignId('tax_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('approval_id')->nullable()->constrained()->nullOnDelete();
            $table->date('order_date');
            $table->date('term_of_payment');
            $table->string('created_by');
            $table->foreignId('sales_id')->nullable()->constrained('users')->nullOnDelete();
            $table->tinyInteger('status_payment')->default(0); // 0 = draf, 1 = belum terbit invoice/Uninvoiced, 2 = outstanding, 3 = lunas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
