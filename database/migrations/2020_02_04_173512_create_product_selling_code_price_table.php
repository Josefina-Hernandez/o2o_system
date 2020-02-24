<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSellingCodePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.product_selling_code_price.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.DESIGN'));
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.WIDTH'));
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'));
            $table->string(config('const_db_tostem.db.product_selling_code_price.column.SPECIAL'))->nullable();
            $table->float(config('const_db_tostem.db.product_selling_code_price.column.AMOUNT'));
            $table->integer(config('const_db_tostem.db.product_selling_code_price.column.WIDTHORG'));
            $table->integer(config('const_db_tostem.db.product_selling_code_price.column.HEIGHTORG'));
            
            $table->index([config('const_db_tostem.db.product_selling_code_price.column.DESIGN'), config('const_db_tostem.db.product_selling_code_price.column.WIDTH'),config('const_db_tostem.db.product_selling_code_price.column.HEIGHT'),config('const_db_tostem.db.product_selling_code_price.column.SPECIAL')]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('const_db_tostem.db.product_selling_code_price.nametable'));
    }
}
