<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsAdminFlagToMMailaddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_mailaddress.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_mailaddress.column.ADMIN_FLG'))->nullable();
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
        Schema::table(config('const_db_tostem.db.m_mailaddress.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_mailaddress.column.ADMIN_FLG'));
        });
    }
}
