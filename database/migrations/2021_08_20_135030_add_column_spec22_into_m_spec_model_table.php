<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSpec22IntoMSpecModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_model_spec.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.m_model_spec.column.SPEC').'22',100)->nullable();
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
            $table->dropColumn(config('const_db_tostem.db.m_model_spec.column.SPEC').'22');
        });
    }
}
