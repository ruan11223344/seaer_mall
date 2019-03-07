<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_log',function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('action');
        });


        Schema::table('user_log', function (Blueprint $table) {
            $table->enum('type',['auth','inquiry','product','company','feedback']);
            $table->enum('action',['delete','create','modify','visit','register','login','logout']);
            $table->index('user_id');
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
