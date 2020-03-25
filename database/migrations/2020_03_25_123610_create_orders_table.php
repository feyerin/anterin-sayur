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
            $table->bigInteger('userId');
            $table->string('orderCode');
            $table->string('address');
            $table->integer('status');
            $table->integer('totalQuantity')->default(0);
            $table->bigInteger('totalPrice')->default(0);
            $table->bigInteger('totalPayment')->default(0);
            $table->bigInteger('totalDiscount')->default(0);
            $table->timestamp('paymentDate')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
