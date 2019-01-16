<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersExtendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    public function up()
    {
        Schema::table('users_extends', function (Blueprint $table) {
            $table->renameColumn('region_id', 'province_id');
            $table->integer('city_id');
        });

        Schema::table('users_extends', function (Blueprint $table) {
            $table->dropColumn('account_type');
        });

        Schema::table('users_extends', function (Blueprint $table) {
            $table->tinyInteger('account_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_extends', function (Blueprint $table) {
            //
        });
    }
}
