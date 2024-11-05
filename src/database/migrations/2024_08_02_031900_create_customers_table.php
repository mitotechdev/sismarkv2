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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('type_customer_id')->default(1)->nullable()->constrained('type_customers')->nullOnDelete()->cascadeOnUpdate();
            $table->string('name')->unique();
            $table->foreignId('category_customer_id')->constrained('category_customers')->cascadeOnUpdate()->cascadeOnDelete(); //bidang usaha ex:PKS,PDAM
            $table->string('npwp');
            $table->string('owner');
            $table->string('email');
            $table->string('phone_number');
            $table->string('address');
            $table->string('city');
            $table->text('desc_technical');
            $table->text('desc_clasification');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
