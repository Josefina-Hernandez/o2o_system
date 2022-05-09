<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddNewColumnTableMQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_quotation.nametable'), function (Blueprint $table) {
            $table->String(config('const_db_tostem.db.m_quotation.column.BUTTON_PDF'))->nullable();
            $table->String(config('const_db_tostem.db.m_quotation.column.BUTTON_MAIL'))->nullable();
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
            $table->dropColumn(config('const_db_tostem.db.m_quotation.column.BUTTON_PDF'));
            $table->dropColumn(config('const_db_tostem.db.m_quotation.column.BUTTON_MAIL'));
        });
    }
}
