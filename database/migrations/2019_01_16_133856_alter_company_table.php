<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCompanyTable extends Migration
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
        Schema::table('company', function (Blueprint $table) {
            $table->renameColumn('company_region_id', 'company_province_id');
            $table->integer('company_city_id');
            $table->string('company_name_in_china')->nullable()->change();
            $table->string('company_name')->nullable()->change();
            $table->string('company_business_type_id')->nullable()->change();
            $table->string('company_business_range_ids')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function (Blueprint $table) {
            //
        });
    }
}
