<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLangMProductSubmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_product_submenu.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_product_submenu.column.M_LANG_ID'))->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_product_submenu.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_product_submenu.column.M_LANG_ID'));
        });
    }
}
