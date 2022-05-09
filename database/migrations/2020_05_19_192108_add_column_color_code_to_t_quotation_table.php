<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnColorCodeToTQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.t_quotation.column.COLOR_CODE'))->nullable();
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
            $table->dropColumn(config('const_db_tostem.db.t_quotation.column.COLOR_CODE'));
        });
    }
}
