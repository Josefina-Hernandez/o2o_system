<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNotNullCtgName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.ctg_trans.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.ctg_trans.column.CTG_NAME'))->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.ctg_trans.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.ctg_trans.column.CTG_NAME'))->nullable(false)->change();
        });
    }
}
