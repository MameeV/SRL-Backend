<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('orders', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('usersID');
          $table->integer('productID');
          $table->string('promoCode')->nullable();
          $table->integer('subtotal');
          $table->integer('tax')->nullable();
          $table->integer('shipping')->nullable();
          $table->integer('total');
          $table->longText('comments')->nullable();
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
