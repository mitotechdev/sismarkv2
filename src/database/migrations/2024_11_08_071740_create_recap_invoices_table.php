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
        Schema::create('recap_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->foreignId('sales_order_id')->constrained('sales_orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date_invoice');
            $table->date('due_date');
            $table->date('date_payment')->nullable();
            $table->decimal('total_payment', 17, 2);
            $table->tinyInteger('status');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recap_invoices');
    }
};
