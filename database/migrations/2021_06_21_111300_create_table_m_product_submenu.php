<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMProductSubmenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_product_submenu.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_product_submenu.column.PRODUCT_ID'))->nullable();
            $table->string(config('const_db_tostem.db.m_product_submenu.column.SPEC_CODE'))->nullable();
            $table->integer(config('const_db_tostem.db.m_product_submenu.column.SORT_ORDER'))->nullable();
            $table->string(config('const_db_tostem.db.m_product_submenu.column.LINK_TEXT'))->nullable();
            $table->text(config('const_db_tostem.db.m_product_submenu.column.LINK_URL'))->nullable();
            $table->string(config('const_db_tostem.db.m_product_submenu.column.DESCRIPTION'))->nullable();
            $table->tinyInteger(config('const_db_tostem.db.common_columns.column.DEL_FLG'))->default('0');
            $table->integer(config('const_db_tostem.db.common_columns.column.ADD_USER_ID'))->nullable();
            $table->timestamp(config('const_db_tostem.db.common_columns.column.ADD_DATETIME'))->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer(config('const_db_tostem.db.common_columns.column.UPD_USER_ID'))->nullable();
            $table->timestamp(config('const_db_tostem.db.common_columns.column.UPD_DATETIME'))->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('const_db_tostem.db.m_product_submenu.nametable'));
    }
}
