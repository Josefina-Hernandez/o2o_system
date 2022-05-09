<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTbTQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
               $table->integer(config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'));
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
               $table->dropColumn(config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'));
         });
    }
}
