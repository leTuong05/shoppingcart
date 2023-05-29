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
            $table->string('order_id');
            $table->string('type');
            $table->integer('checkout_status');
            $table->string('phone_number');
            $table->string('ward');
            $table->string('city');
            $table->string('district');
            $table->string('payment_type');
            $table->integer('user_id');
            $table->string('subtotal');
            $table->string('name');
            $table->string('details_address');
            $table->string('note_shipping');
            $table->string('is_read');
            $table->softDeletes();
            $table->timestamps();
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
