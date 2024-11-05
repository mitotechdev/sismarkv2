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
        Schema::create('workplans', function (Blueprint $table) {
            $table->id();
            $table->string('code_workplan')->unique();
            $table->foreignId('sales_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_customer_id')->constrained('category_customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('market_progress_id')->nullable()->constrained('market_progress')->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('status')->default(0); // 0 = Draf, 1 = progress, 2 = Done, 3 = Reject, 4 = Closed
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('code_latest_progress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workplans');
    }
};
