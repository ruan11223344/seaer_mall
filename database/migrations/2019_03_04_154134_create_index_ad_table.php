<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('index_ad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id');
            $table->string('user_id');
            $table->mediumText('user_message');
            $table->mediumText('admin_message');
            $table->boolean('is_reply');
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
        Schema::dropIfExists('index_ad');
    }
}
