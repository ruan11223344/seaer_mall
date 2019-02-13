<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
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
            $table->string('company_id');
            $table->string('product_origin_id'); //产品原始ID PU_KY_0392817281
            $table->string('product_categories_id'); //商品分类ID
            $table->string('product_name'); //商品名称
            $table->string('product_sku_no'); //商品型号 必填
            $table->json('product_keywords'); //商品关键词 {["好大","鸡蛋","家禽"]} 最少1个
            $table->json('product_images');  //{"main":"http://www.wdsdsa.com/1.jpg","1":"http://www.xx.com/2.jpg","2":"http://www.xx.com/2.jpg"}
            $table->tinyInteger('product_status'); //商品状态 1在售  0在仓库中`
            $table->tinyInteger('product_audit_status')->default(0); //审核状态 0未通过审核 1通过审核   2审核中
            $table->timestamp('product_publishing_time')->nullable(); //商品发布的时间 只能是未来？或者为空
            $table->string('product_price_id'); //价格id
            $table->timestamps();
            $table->softDeletes();
            $table->index('product_name');
            $table->index('product_origin_id');
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
