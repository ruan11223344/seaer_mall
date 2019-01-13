<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersExtendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_extends', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->string('af_id')->unique()->nullable();
            $table->string('member_id')->unique()->nullable();
            $table->integer('company_id')->unique()->nullable();
            $table->enum('account_type',['company','individual']);
            $table->integer('country_id')->nullable();
            $table->integer('region_id')->nullable();
            $table->char('calling_code')->nullable();
            $table->char('mobile')->nullable();
            $table->enum('sex',['Mr','Mrs','Miss'])->nullable();
            $table->string('contact_full_name')->nullable();
            $table->string('detailed_address')->nullable();
            $table->string('id_card_name')->nullable();
            $table->string('id_card_num')->nullable();
            $table->string('id_card_positive_pic_url')->nullable();
            $table->string('id_card_negative_pic_url')->nullable();
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
        Schema::dropIfExists('users_extends');
    }
}
