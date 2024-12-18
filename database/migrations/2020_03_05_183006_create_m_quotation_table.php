<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_quotation.nametable'), function (Blueprint $table) {
            $table->increments(config('const_db_tostem.db.m_quotation.column.M_QUOTATION_ID'));
            $table->String(config('const_db_tostem.db.m_quotation.column.QUOTATION_SESSION'))->nullable();
            $table->integer(config('const_db_tostem.db.m_quotation.column.QUOTATION_USER'));
            $table->String(config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE'))->nullable();
            $table->String(config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'))->nullable();

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
        Schema::dropIfExists(config('const_db_tostem.db.m_quotation.nametable'));
    }
}
