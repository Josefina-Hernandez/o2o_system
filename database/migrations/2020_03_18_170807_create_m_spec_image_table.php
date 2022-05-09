<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMSpecImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_spec_image.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_spec_image.column.PRODUCT_ID'))->nullable()->unsigned();
            $table->string(config('const_db_tostem.db.m_spec_image.column.IMG_PATH'))->nullable();
            $table->string(config('const_db_tostem.db.m_spec_image.column.IMG_NAME'))->nullable();
            $table->string(config('const_db_tostem.db.m_spec_image.column.OPTION1'))->nullable();
            $table->string(config('const_db_tostem.db.m_spec_image.column.OPTION2'))->nullable();
            $table->string(config('const_db_tostem.db.m_spec_image.column.OPTION3'))->nullable();
            for($i = 1; $i <= 27; $i++)
            {
                $table->string(config('const_db_tostem.db.m_spec_image.column.SPEC').$i)->nullable();
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
        Schema::dropIfExists(config('const_db_tostem.db.m_spec_image.nametable'));
    }
}
