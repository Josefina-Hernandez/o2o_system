<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryImportProductSellingCodePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.history_import_product_selling_code_price.nametable'), function (Blueprint $table) {
            $table->increments('id');
            $table->string(config('const_db_tostem.db.history_import_product_selling_code_price.column.FILENAME'));
            $table->integer(config('const_db_tostem.db.history_import_product_selling_code_price.column.USER'));
            $table->string(config('const_db_tostem.db.history_import_product_selling_code_price.column.STATUS'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('const_db_tostem.db.history_import_product_selling_code_price.nametable'));
    }
}
