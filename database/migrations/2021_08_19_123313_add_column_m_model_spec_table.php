<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMModelSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_model_spec.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.m_model_spec.column.SPEC').'14',100)->nullable()
                ->after(config('const_db_tostem.db.m_model_spec.column.SPEC').'12');
            $table->string(config('const_db_tostem.db.m_model_spec.column.SPEC').'39',100)->nullable()
                ->after(config('const_db_tostem.db.m_model_spec.column.SPEC').'37');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_model_spec.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_model_spec.column.SPEC').'14');
            $table->dropColumn(config('const_db_tostem.db.m_model_spec.column.SPEC').'39');
        });
    }
}
