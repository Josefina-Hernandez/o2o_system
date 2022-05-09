<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsToMQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_quotation.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_quotation.column.QUOTATION_DEPARMENT'));
            $table->dropColumn(config('const_db_tostem.db.m_quotation.column.QUOTATION_USER'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_quotation.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_quotation.column.QUOTATION_DEPARMENT'));
            $table->string(config('const_db_tostem.db.m_quotation.column.QUOTATION_USER'));
        });
    }
}
