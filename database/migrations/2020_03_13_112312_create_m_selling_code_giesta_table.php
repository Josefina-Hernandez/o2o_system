<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMSellingCodeGiestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_selling_code_giesta.nametable'), function (Blueprint $table) {
            $table->String(config('const_db_tostem.db.m_selling_code_giesta.column.SELLING_CODE'))->nullable();
            $table->integer(config('const_db_tostem.db.m_selling_code_giesta.column.PRODUCT_ID'))->nullable();
            $table->integer(config('const_db_tostem.db.m_selling_code_giesta.column.CTG_PART_ID'))->nullable();
            for($i = 1; $i <= 7; $i++)
            {
                $table->String(config('const_db_tostem.db.m_selling_code_giesta.column.SPEC').'5'.$i)->nullable();
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
        Schema::dropIfExists(config('const_db_tostem.db.m_selling_code_giesta.nametable'));
    }
}
