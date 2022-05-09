<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_quotation.nametable'), function (Blueprint $table) {
            $table->addColumn('longText', config('const_db_tostem.db.m_quotation.column.DATA_CART'))->nullable()->change();
            $table->addColumn('longText',config('const_db_tostem.db.m_quotation.column.HTML_CART'))->nullable()->change();
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
            $table->addColumn('longText', config('const_db_tostem.db.m_quotation.column.DATA_CART'))->change();
            $table->addColumn('longText',config('const_db_tostem.db.m_quotation.column.HTML_CART'))->change();
        });
    }
}
