<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMColorCtgProdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_color_ctg_prod.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_color_ctg_prod.column.M_COLOR_ID'))->unsigned();
            $table->integer(config('const_db_tostem.db.m_color_ctg_prod.column.CTG_PROD_ID'))->unsigned();
            $table->string(config('const_db_tostem.db.m_color_ctg_prod.column.IMG_PATH'))->nullable();
            $table->string(config('const_db_tostem.db.m_color_ctg_prod.column.IMG_NAME'))->nullable();
            $table->primary([config('const_db_tostem.db.m_color_ctg_prod.column.M_COLOR_ID'),config('const_db_tostem.db.m_color_ctg_prod.column.CTG_PROD_ID')]);

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
        Schema::dropIfExists(config('const_db_tostem.db.m_color_ctg_prod.nametable'));
    }
}
