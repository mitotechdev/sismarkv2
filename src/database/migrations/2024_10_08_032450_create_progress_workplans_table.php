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
        Schema::create('progress_workplans', function (Blueprint $table) {
            $table->id();
            $table->string('code_progress')->unique();
            $table->date('date_progress');
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('workplan_id')->constrained('workplans')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('market_progress_id')->constrained('market_progress')->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('issue');
            $table->text('next_action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_workplans');
    }
};
