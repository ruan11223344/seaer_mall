<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductAuditTable extends Migration
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

        Schema::table('product_audit', function(Blueprint $table)
        {
            $table->dropColumn('status');
        });

        Schema::table('product_audit',function (Blueprint $table) {
            $table->integer('admin_id')->nullable()->change();
            $table->enum('status',['success','fail','waiting']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_audit');
    }
}
