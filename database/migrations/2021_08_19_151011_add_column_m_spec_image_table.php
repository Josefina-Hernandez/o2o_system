<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMSpecImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_spec_image.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.m_spec_image.column.OPTION5'))->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_spec_image.nametable'), function (Blueprint $table) {
             $table->dropColumn(config('const_db_tostem.db.m_spec_image.column.OPTION5'));
        });
    }
}
