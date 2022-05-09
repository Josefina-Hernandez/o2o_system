<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMFenceBaseRecommendWallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_fence_base_recommend_wall.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_fence_base_recommend_wall.column.PITCH'))->unsigned();
            $table->integer(config('const_db_tostem.db.m_fence_base_recommend_wall.column.MIN_WIDTH'))->nullable();
            $table->integer(config('const_db_tostem.db.m_fence_base_recommend_wall.column.MAX_WIDTH'))->nullable();
            
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
        Schema::dropIfExists(config('const_db_tostem.db.m_fence_base_recommend_wall.nametable'));
    }
}
