<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_price', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('price_type',['base','ladder']); //枚举
            $table->json('base_price')-> nullable(); //{"min_order":"10","min_price":"500","max_price":"1000"}
            $table->json('ladder_price')->nullable(); //{[["min_order":"10","order_price":"800"}],["min_order":"20","order_price":"500"}]]
            $table->string('currency')->default('ksh');;  //ksh cny
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
        Schema::dropIfExists('products_price');
    }
}
