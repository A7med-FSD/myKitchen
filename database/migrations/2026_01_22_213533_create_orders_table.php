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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_phone');
            $table->string('customer_name');
            $table->enum('status', ['pending', 'in_progress', 'ready', 'delivered', 'cancelled'])->default('pending');
            $table->string('order_code');
            $table->decimal('total_price', 10, 2);
            $table->text('delivery_notes')->nullable();
            $table->string('address_link')->nullable(); 
            $table->string('payment_method'); 
            $table->text('address_text')->nullable();
            $table->integer('promotion_value')->nullable();
            $table->foreignId('promotion_id')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
