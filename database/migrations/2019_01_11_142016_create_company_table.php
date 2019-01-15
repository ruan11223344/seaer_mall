<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->integer('company_country_id');
            $table->integer('company_region_id');
            $table->string('company_detailed_address')->nullable();
            $table->string('company_owner')->nullable();
            $table->string('company_name_in_china')->nullable();
            $table->string('company_business_license')->nullable();
            $table->string('company_business_license_pic_url')->nullable();
            $table->string('company_established_time')->nullable();
            $table->string('company_website')->nullable();
            $table->enum('company_number_of_employees',['less_than_5', '5-50','51-200','201-500','501-1000','above_1000'])->nullable();
            $table->text('company_profile')->nullable();
            $table->integer('company_business_type_id');
            $table->json('company_business_range_ids'); //注意 以json对象中的数组方式储存！
            $table->integer('company_calling_code')->nullable();
            $table->char('company_mobile_phone')->nullable();
            $table->string('company_sales_platform')->nullable();
            $table->string('company_main_products')->nullable();
            $table->string('company_logo_url')->nullable();
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
        Schema::dropIfExists('company');
    }
}
