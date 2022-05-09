<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsMailaddressIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.users.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.users.column.M_MAILADDRESS_ID'))->unsigned()->nullable();
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
        Schema::table(config('const_db_tostem.db.users.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.users.users.M_MAILADDRESS_ID'));
            
        });
    }
}
