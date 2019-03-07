<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAdminLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('admin_log',function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('action');
        });


        Schema::table('admin_log', function (Blueprint $table) {
            $table->enum('type',['auth','inquiry','audit_company','audit_product','permissions','role','user_agreements','system_announcement','system_article','ad','feedback']);
            $table->enum('action',['delete','create','modify','not_approved','approved','ban','allow','off_shelves','login','register','logout']);
            $table->index('admin_id');
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