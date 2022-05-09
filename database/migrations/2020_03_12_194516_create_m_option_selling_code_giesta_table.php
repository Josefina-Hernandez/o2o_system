<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMOptionSellingCodeGiestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_option_selling_code_giesta.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_option_selling_code_giesta.column.OPTION_CTG_SPEC_ID'))->nullable();
            $table->integer(config('const_db_tostem.db.m_option_selling_code_giesta.column.M_COLOR_ID'))->nullable();
            $table->String(config('const_db_tostem.db.m_option_selling_code_giesta.column.SELLING_CODE'))->nullable();
            $table->String(config('const_db_tostem.db.m_option_selling_code_giesta.column.DESCRIPTION'))->nullable();
            $table->integer(config('const_db_tostem.db.m_option_selling_code_giesta.column.PRODUCT_ID'))->nullable();
            $table->String(config('const_db_tostem.db.m_option_selling_code_giesta.column.SPEC_HANDLE_TYPE_PRODUCT_ID'))->nullable();
            $table->String(config('const_db_tostem.db.m_option_selling_code_giesta.column.OPTION4'))->nullable();
            $table->String(config('const_db_tostem.db.m_option_selling_code_giesta.column.OPTION5'))->nullable();
            for($i = 1; $i <= 7; $i++)
            {
                $table->String(config('const_db_tostem.db.m_option_selling_code_giesta.column.SPEC').'5'.$i)->nullable();
            }

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
        Schema::dropIfExists(config('const_db_tostem.db.m_option_selling_code_giesta.nametable'));
    }
}
