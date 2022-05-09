<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMDefineHardcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_define_hardcode.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.m_define_hardcode.column.COLUMN_NAME'));
            $table->string(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE1'));
            $table->string(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE2'));
            $table->string(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE3'));
            $table->string(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE4'));
            $table->string(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE5'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_define_hardcode.nametable'), function (Blueprint $table) {
        	$table->dropColumn(config('const_db_tostem.db.m_define_hardcode.column.COLUMN_NAME'));
            $table->dropColumn(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE1'));
            $table->dropColumn(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE2'));
            $table->dropColumn(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE3'));
            $table->dropColumn(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE4'));
            $table->dropColumn(config('const_db_tostem.db.m_define_hardcode.column.DEF_VALUE5'));
        });
    }
}
