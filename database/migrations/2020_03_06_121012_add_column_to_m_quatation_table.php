<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToMQuatationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_quotation.nametable'), function (Blueprint $table) {
            $table->addColumn('longText', config('const_db_tostem.db.m_quotation.column.DATA_CART'));
            $table->addColumn('longText',config('const_db_tostem.db.m_quotation.column.HTML_CART'));
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
            $table->dropColumn(config('const_db_tostem.db.m_quotation.column.DATA_CART'));
            $table->dropColumn(config('const_db_tostem.db.m_quotation.column.HTML_CART'));
        });
    }
}
