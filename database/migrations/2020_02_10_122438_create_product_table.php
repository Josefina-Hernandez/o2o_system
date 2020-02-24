<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.product.nametable'), function (Blueprint $table) {
            $table->increments(config('const_db_tostem.db.product.column.PRODUCT_ID'));
            $table->integer(config('const_db_tostem.db.product.column.SORT_ORDER'));
            $table->integer(config('const_db_tostem.db.product.column.CTG_PROD_ID'))->unsigned();
            $table->integer(config('const_db_tostem.db.product.column.CTG_RISE_ID'))->unsigned()->nullable();
            $table->string(config('const_db_tostem.db.product.column.IMG_PATH'))->nullable();
            $table->string(config('const_db_tostem.db.product.column.IMG_NAME'))->nullable();
            $table->string(config('const_db_tostem.db.product.column.VIEWER_FLG'))->nullable();

            $table->tinyInteger(config('const_db_tostem.db.common_columns.column.DEL_FLG'))->default('0');
            $table->integer(config('const_db_tostem.db.common_columns.column.ADD_USER_ID'))->nullable();
            $table->timestamp(config('const_db_tostem.db.common_columns.column.ADD_DATETIME'))->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer(config('const_db_tostem.db.common_columns.column.UPD_USER_ID'))->nullable();
            $table->timestamp(config('const_db_tostem.db.common_columns.column.UPD_DATETIME'))->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('const_db_tostem.db.product.nametable'));
    }
}
