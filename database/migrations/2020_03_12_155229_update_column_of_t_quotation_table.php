<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnOfTQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.t_quotation.column.W'))->nullable()->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.H'))->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.t_quotation.column.W'))->change();
            $table->string(config('const_db_tostem.db.t_quotation.column.H'))->change();
        });
    }
}
