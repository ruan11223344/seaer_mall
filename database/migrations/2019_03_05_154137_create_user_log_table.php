<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_log', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['register','inquiry','product','company','feedback']);
            $table->enum('action',['delete','create','modify','visit']);
            $table->string('ip');
            $table->integer('user_id');
            $table->integer('type_for_id');
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
        Schema::drop('user_log');
    }
}
