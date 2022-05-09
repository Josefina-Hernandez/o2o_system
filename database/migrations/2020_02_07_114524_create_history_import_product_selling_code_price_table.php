<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryImportProductSellingCodePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.history_import_product_selling_code_price.nametable'), function (Blueprint $table) {
            $table->increments(config('const_db_tostem.db.history_import_product_selling_code_price.column.ID'));
            $table->string(config('const_db_tostem.db.history_import_product_selling_code_price.column.FILENAME'));
            $table->tinyInteger(config('const_db_tostem.db.history_import_product_selling_code_price.column.OPTION'));
            $table->string(config('const_db_tostem.db.history_import_product_selling_code_price.column.STATUS'));
            
            
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
        Schema::dropIfExists(config('const_db_tostem.db.history_import_product_selling_code_price.nametable'));
    }
}
