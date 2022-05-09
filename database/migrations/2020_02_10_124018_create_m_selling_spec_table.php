<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMSellingSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_selling_spec.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.m_selling_spec.column.SPEC_CODE'),100);
            $table->string(config('const_db_tostem.db.m_selling_spec.column.SPEC_GROUP'));
            $table->integer(config('const_db_tostem.db.m_selling_spec.column.SORT_ORDER'))->nullable();
            $table->string(config('const_db_tostem.db.m_selling_spec.column.IMG_PATH'))->nullable();
            $table->string(config('const_db_tostem.db.m_selling_spec.column.IMG_NAME'))->nullable();
            
            $table->primary(config('const_db_tostem.db.m_selling_spec.column.SPEC_CODE'));

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
        Schema::dropIfExists(config('const_db_tostem.db.m_selling_spec.nametable'));
    }
}
