<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMMailaddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_mailaddress.nametable'), function (Blueprint $table) {
            $table->String(config('const_db_tostem.db.m_mailaddress.column.DEPARTMENT_CODE'), 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table(config('const_db_tostem.db.m_mailaddress.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_mailaddress.column.DEPARTMENT_CODE'));
        });
    }
}
