<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('products', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('categoryID');
        $table->string('productName')->unique();
        $table->string('modelNumber')->nullable();
        $table->string('serialNumber')->nullable();
        $table->longText('image');
        $table->longText('description');
        $table->string('manuelLink')->nullable();
        $table->string('boxSize')->nullable();
        $table->string('deliverableLink')->nullable();
        $table->integer('price');
        $table->integer('stock');
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
        Schema::dropIfExists('products');
    }
}
