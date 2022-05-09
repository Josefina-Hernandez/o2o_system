<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnMSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_size_limit.nametable'), function (Blueprint $table) {             
            $table->string(config('const_db_tostem.db.m_size_limit.column.SPEC33'), 50)->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_size_limit.nametable'), function (Blueprint $table) {             
            $table->dropColumn(config('const_db_tostem.db.m_size_limit.column.SPEC33'), 50)->nullable();            
        });
    }
}
