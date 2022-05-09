<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMOptionSellingCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_option_selling_code.nametable'), function (Blueprint $table) {
            $table->String(config('const_db_tostem.db.m_option_selling_code.column.DESCRIPTION'))->nullable()->after(config('const_db_tostem.db.m_option_selling_code.column.SELLING_CODE'));
           ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_option_selling_code.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_option_selling_code.column.DESCRIPTION'));
        });
    }
}
