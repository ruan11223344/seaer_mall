<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsAttrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_attr', function (Blueprint $table) {
            $table->increments('id');
            $table->json('attr_specs'); //属性规格  row1 [{"颜色":"绿色"},{"颜色":"黑色"},{"容量":"32G"},{"容量":"64G"},{"容量":"128G"},{"尺寸":"超大"},{"尺寸":"超小"}]
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
        Schema::dropIfExists('products_attr');
    }
}
