<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMFenceStrightJointBaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.m_fence_stright_joint_base.nametable'), function (Blueprint $table) {
            $table->integer(config('const_db_tostem.db.m_fence_stright_joint_base.column.PITCH'))->unsigned();
            $table->integer(config('const_db_tostem.db.m_fence_stright_joint_base.column.MIN_MM'))->nullable();
            $table->integer(config('const_db_tostem.db.m_fence_stright_joint_base.column.MAX_MM'))->nullable();
            $table->integer(config('const_db_tostem.db.m_fence_stright_joint_base.column.QUANTITY'))->nullable();
            $table->integer(config('const_db_tostem.db.m_fence_stright_joint_base.column.DIFFERENCE_PANEL'))->nullable();

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
        Schema::dropIfExists(config('const_db_tostem.db.m_fence_stright_joint_base.nametable'));
    }
}
