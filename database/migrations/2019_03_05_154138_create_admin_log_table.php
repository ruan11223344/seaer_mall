<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_log', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['admin','register','inquiry','audit_company','audit_product','permissions','role','user_agreements','system_announcement','system_article','ad','feedback']);
            $table->enum('action',['delete','create','modify','not_approved','approved','ban','allow','off_shelves']);
            $table->string('ip');
            $table->integer('admin_id');
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
        Schema::drop('admin_log');
    }
}