<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateTypeColumnPriceTableOptionSellingCodePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.option_selling_code_price.nametable'), function (Blueprint $table) {
               $table->string(config('const_db_tostem.db.option_selling_code_price.column.AMOUNT'),50)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.option_selling_code_price.nametable'), function (Blueprint $table) {
               $table->float(config('const_db_tostem.db.option_selling_code_price.column.AMOUNT'))->change();
        });
    }
}
