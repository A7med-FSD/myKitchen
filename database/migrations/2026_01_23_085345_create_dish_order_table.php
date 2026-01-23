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
        Schema::create('dish_order', function (Blueprint $table) {
            $table->integer('quantity');
            $table->integer('dish_price_at_order');
            $table->string('dish_name_at_order');
            $table->foreignId('dish_id');
            $table->foreignId('order_id')->constrained();
            $table->primary(['dish_id', 'order_id']);
            $table->integer('promotion_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_order');
    }
};
