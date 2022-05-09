<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.product_trans.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.product_trans.column.PRODUCT_NAME'))->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.product_trans.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.product_trans.column.PRODUCT_NAME'))->change();
        });
    }
}
