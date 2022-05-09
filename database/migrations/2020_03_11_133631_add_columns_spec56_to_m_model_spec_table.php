<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSpec56ToMModelSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_model_spec.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.m_model_spec.column.SPEC').'56',100)->nullable()->after(config('const_db_tostem.db.m_model_spec.column.SPEC').'12');
           ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_model_item.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_model_spec.column.SPEC').'56');
        });
    }
}
