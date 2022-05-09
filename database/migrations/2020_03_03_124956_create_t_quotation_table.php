<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->increments(config('const_db_tostem.db.t_quotation.column.NO'));
            $table->string(config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'));
            $table->string(config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE'));
            $table->string(config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'));
            $table->string(config('const_db_tostem.db.t_quotation.column.ITEM'));
            $table->string(config('const_db_tostem.db.t_quotation.column.HL'));
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL'));
            $table->string(config('const_db_tostem.db.t_quotation.column.DESIGN'));
            $table->string(config('const_db_tostem.db.t_quotation.column.REF'));
            $table->string(config('const_db_tostem.db.t_quotation.column.QTY'));
            $table->string(config('const_db_tostem.db.t_quotation.column.ONE_WINDOW'));
            $table->string(config('const_db_tostem.db.t_quotation.column.JOINT'));
            $table->string(config('const_db_tostem.db.t_quotation.column.SCREEN'));
            $table->string(config('const_db_tostem.db.t_quotation.column.OFF_SPEC'));
            $table->string(config('const_db_tostem.db.t_quotation.column.MAIN_GLASS'));
            $table->string(config('const_db_tostem.db.t_quotation.column.COLOR'));
            $table->string(config('const_db_tostem.db.t_quotation.column.W'));
            $table->string(config('const_db_tostem.db.t_quotation.column.H'));
            $table->string(config('const_db_tostem.db.t_quotation.column.W_OPENING'));
            $table->string(config('const_db_tostem.db.t_quotation.column.H_OPENING'));
            $table->string(config('const_db_tostem.db.t_quotation.column.SPECIAL_CODE'));
            $table->string(config('const_db_tostem.db.t_quotation.column.GLASS_TYPE'));
            $table->string(config('const_db_tostem.db.t_quotation.column.GLASS_HIC_ENESS'));
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL_REFERENCE'));
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL_DESCRIPTION'));
            
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
        Schema::dropIfExists(config('const_db_tostem.db.t_quotation.nametable'));
    }
}
