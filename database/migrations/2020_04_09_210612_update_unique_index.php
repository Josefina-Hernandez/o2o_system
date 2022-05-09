<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUniqueIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.ctg_trans.nametable'), function (Blueprint $table) {
            $table->unique([config('const_db_tostem.db.ctg_trans.column.CTG_ID'), config('const_db_tostem.db.ctg_trans.column.M_LANG_ID')], 'ctg_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.product_trans.nametable'), function (Blueprint $table) {
            $table->unique([config('const_db_tostem.db.product_trans.column.PRODUCT_ID'), config('const_db_tostem.db.product_trans.column.M_LANG_ID')],'product_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.m_color_trans.nametable'), function (Blueprint $table) {
            $table->unique([config('const_db_tostem.db.m_color_trans.column.M_COLOR_ID'), config('const_db_tostem.db.m_color_trans.column.M_LANG_ID')], 'm_color_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.m_model_trans.nametable'), function (Blueprint $table) {
            $table->unique([config('const_db_tostem.db.m_model_trans.column.M_MODEL_ID'), config('const_db_tostem.db.m_model_trans.column.M_LANG_ID'), config('const_db_tostem.db.m_model_trans.column.PRODUCT_ID')], 'm_model_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.m_selling_spec_trans.nametable'), function (Blueprint $table) {
            $table->unique([config('const_db_tostem.db.m_selling_spec_trans.column.SPEC_CODE'), config('const_db_tostem.db.m_selling_spec_trans.column.M_LANG_ID')],'m_selling_spec_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.m_model_item_trans.nametable'), function (Blueprint $table) {
            $table->unique([config('const_db_tostem.db.m_model_item_trans.column.M_MODEL_ITEM_ID'), config('const_db_tostem.db.m_model_item_trans.column.M_LANG_ID')], 'm_model_item_trans_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.ctg_trans.nametable'), function (Blueprint $table) {
            $table->dropUnique('ctg_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.product_trans.nametable'), function (Blueprint $table) {
            $table->dropUnique('product_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.m_color_trans.nametable'), function (Blueprint $table) {
            $table->dropUnique('m_color_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.m_model_trans.nametable'), function (Blueprint $table) {
            $table->dropUnique('m_model_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.m_selling_spec_trans.nametable'), function (Blueprint $table) {
            $table->dropUnique('m_selling_spec_trans_unique');
        });
        Schema::table(config('const_db_tostem.db.m_model_item_trans.nametable'), function (Blueprint $table) {
            $table->dropUnique('m_model_item_trans_unique');
        });
    }
}
