<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->foreignId('order_status_id')
                ->constrained('order_statuses')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('payment_id')
                ->constrained('order_statuses')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->uuid('uuid');
            $table->json('products');
            $table->json('address');
            $table->float('delivery_fee');
            $table->float('amount');
            $table->timestamps();
            $table->timestamp('shipped_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
