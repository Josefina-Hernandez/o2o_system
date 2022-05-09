<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnImgToMSellingCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_selling_code.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.m_selling_code.column.IMG_PATH'))->nullable()->after(config('const_db_tostem.db.m_selling_code.column.SELLING_CODE'));
            $table->string(config('const_db_tostem.db.m_selling_code.column.IMG_NAME'))->nullable()->after(config('const_db_tostem.db.m_selling_code.column.IMG_PATH'));
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_selling_code.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_selling_code.column.IMG_PATH'));
            $table->dropColumn(config('const_db_tostem.db.m_selling_code.column.IMG_NAME'));
        });
    }
}
