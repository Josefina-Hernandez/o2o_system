<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToMSellingCodeGiestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_selling_code_giesta.nametable'), function (Blueprint $table) {
            $table->increments(config('const_db_tostem.db.m_selling_code_giesta.column.M_SELLING_CODE_GIESTA_ID'))->first();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_selling_code_giesta.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_selling_code_giesta.column.M_SELLING_CODE_GIESTA_ID'));
        });
    }
}
