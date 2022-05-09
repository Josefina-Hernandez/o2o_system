<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMModelItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_model_item.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_model_item.column.SORT_ORDER'))->nullable()->after(config('const_db_tostem.db.m_model_item.column.M_MODEL_ITEM_ID'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_model_item.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_model_item.column.SORT_ORDER'));
        });
    }
}
