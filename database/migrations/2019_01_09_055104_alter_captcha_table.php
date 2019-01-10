<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCaptchaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('captcha', function (Blueprint $table) {
            $table->dropColumn('verifly_from');
        });

        Schema::table('captcha', function (Blueprint $table) {
            $table->string('verify_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('captcha', function (Blueprint $table) {
            //
        });
    }
}
