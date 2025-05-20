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
        Schema::create('payments', function (Blueprint $table) {
            $table->foreignId('reseravation_id')->constrained();
            $table->enum('payment_option', ['option1', 'option2']);
            $table->decimal('amount', 10, 2);
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('service_charge', 10, 2);
            $table->decimal('total_amount', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
