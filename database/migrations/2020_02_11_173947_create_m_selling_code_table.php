<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMSellingCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_selling_code.nametable'), function (Blueprint $table) {
            $table->increments('m_selling_code_id');
            $table->string(config('const_db_tostem.db.m_selling_code.column.SELLING_CODE'),100);
            for($i = 1; $i<=50; $i++)
            {
                $name_op = 'option'.$i;
                $table->string(config('const_db_tostem.db.m_selling_code.column.OPTION').$i,100)->nullable();

            }
            $table->integer(config('const_db_tostem.db.m_selling_code.column.PRODUCT_ID'))->unsigned()->nullable();
            for($i = 1; $i<=100; $i++)
            {
                $name = 'spec'.$i;
                $table->string(config('const_db_tostem.db.m_selling_code.column.SPEC').$i,100)->nullable();
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
        Schema::dropIfExists(config('const_db_tostem.db.m_selling_code.nametable'));
    }
}
