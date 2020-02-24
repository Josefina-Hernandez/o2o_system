<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_model.nametable'), function (Blueprint $table) {
            $table->increments(config('const_db_tostem.db.m_model.column.M_MODEL_ID'));
            $table->integer(config('const_db_tostem.db.m_model.column.VIEWER_FLG'))->nullable();
            $table->integer(config('const_db_tostem.db.m_model.column.PRODUCT_FLG'))->nullable();
            $table->string(config('const_db_tostem.db.m_model.column.IMG_PATH'))->nullable();
            $table->string(config('const_db_tostem.db.m_model.column.IMG_NAME'))->nullable();
            $table->integer(config('const_db_tostem.db.m_model.column.CTG_MODEL_ID'))->unsigned()->unsigned();
            $table->integer(config('const_db_tostem.db.m_model.column.SORT_ORDER'))->nullable();

            
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
        Schema::dropIfExists(config('const_db_tostem.db.m_model.nametable'));
    }
}
