<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsToTQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.t_quotation.column.M_QUOTATION_ID'))->unsigned();
            $table->dropColumn(config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'));

            $table->dropColumn(config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE'));
            $table->dropColumn(config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'));
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
            $table->dropColumn(config('const_db_tostem.db.t_quotation.column.M_QUOTATION_ID'));
            $table->string(config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'));
            $table->string(config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE'));
            $table->string(config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'));
        });
    }
}
