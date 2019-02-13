<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('group_name');
            $table->integer('parent_id')->default(0);
//            $table->integer('sort')->default(0);
            $table->boolean('show_home_page')->default(true); //是否显示在店铺首页分类中
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
        Schema::dropIfExists('products_group');
    }
}
