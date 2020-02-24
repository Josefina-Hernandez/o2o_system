<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckProductModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.check_product_model.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.check_product_model.column.PRODUCT_ID'))->unsigned();
            $table->integer(config('const_db_tostem.db.check_product_model.column.M_MODEL_ID'))->unsigned();
            $table->integer(config('const_db_tostem.db.check_product_model.column.M_LANG_ID'))->unsigned();
            $table->string(config('const_db_tostem.db.check_product_model.column.MODEL_NAME'))->nullable();
            
            $table->primary([config('const_db_tostem.db.check_product_model.column.PRODUCT_ID'),config('const_db_tostem.db.check_product_model.column.M_MODEL_ID'),config('const_db_tostem.db.check_product_model.column.M_LANG_ID')]);
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
        Schema::dropIfExists(config('const_db_tostem.db.check_product_model.nametable'));
    }
}
