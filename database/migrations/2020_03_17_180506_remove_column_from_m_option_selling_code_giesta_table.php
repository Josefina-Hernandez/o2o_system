<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnFromMOptionSellingCodeGiestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_option_selling_code_giesta.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_option_selling_code_giesta.column.SPEC_HANDLE_TYPE_PRODUCT_ID'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_option_selling_code_giesta.nametable'), function (Blueprint $table) {
            $table->String(config('const_db_tostem.db.m_option_selling_code_giesta.column.SPEC_HANDLE_TYPE_PRODUCT_ID'))->nullable();
        });
    }
}
