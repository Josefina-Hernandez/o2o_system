<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.ITEM'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.HL'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.REF'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.ONE_WINDOW'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.JOINT'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.SCREEN'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.OFF_SPEC'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.MAIN_GLASS'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.W_OPENING'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.H_OPENING'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.SPECIAL_CODE'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.GLASS_TYPE'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.GLASS_HIC_ENESS'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL_REFERENCE'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL_DESCRIPTION'))->nullable()->change();
            $table->text(config('const_db_tostem.db.t_quotation.column.DESIGN'))->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.t_quotation.column.ITEM'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.HL'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.REF'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.ONE_WINDOW'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.JOINT'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.SCREEN'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.OFF_SPEC'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.MAIN_GLASS'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.W_OPENING'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.H_OPENING'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.SPECIAL_CODE'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.GLASS_TYPE'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.GLASS_HIC_ENESS'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL_REFERENCE'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.MATERIAL_DESCRIPTION'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.DESIGN'))->change();
        });
    }
}
