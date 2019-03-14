<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterArticleTable extends Migration
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
        Schema::table('article', function(Blueprint $table)
        {
            $table->dropColumn('type');
        });

        Schema::table('article',function (Blueprint $table) {
            $table->enum('type',['system_article','system_announcement','buyers_register_agreement','merchants_register_agreement']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
