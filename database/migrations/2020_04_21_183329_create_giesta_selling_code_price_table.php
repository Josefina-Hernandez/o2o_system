<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiestaSellingCodePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('const_db_tostem.db.giesta_selling_code_price.nametable'), function (Blueprint $table) {
            $table->increments(config('const_db_tostem.db.giesta_selling_code_price.column.ID'));
            $table->string(config('const_db_tostem.db.giesta_selling_code_price.column.DESIGN'), 50);
            $table->unsignedInteger(config('const_db_tostem.db.giesta_selling_code_price.column.WIDTH'))->nullable();
            $table->unsignedInteger(config('const_db_tostem.db.giesta_selling_code_price.column.HEIGHT'))->nullable();
            $table->string(config('const_db_tostem.db.giesta_selling_code_price.column.SPECIAL'), 50)->nullable();
            $table->float(config('const_db_tostem.db.giesta_selling_code_price.column.AMOUNT'));
            $table->string(config('const_db_tostem.db.giesta_selling_code_price.column.WIDTHORG'), 50)->nullable();
            $table->string(config('const_db_tostem.db.giesta_selling_code_price.column.HEIGHTORG'), 50)->nullable();
            $table->index([config('const_db_tostem.db.giesta_selling_code_price.column.DESIGN'), config('const_db_tostem.db.giesta_selling_code_price.column.WIDTH'),config('const_db_tostem.db.giesta_selling_code_price.column.HEIGHT'),config('const_db_tostem.db.giesta_selling_code_price.column.SPECIAL')],'index_price_key1');
            $table->index([config('const_db_tostem.db.giesta_selling_code_price.column.DESIGN'), config('const_db_tostem.db.giesta_selling_code_price.column.WIDTHORG'),config('const_db_tostem.db.giesta_selling_code_price.column.HEIGHTORG'),config('const_db_tostem.db.giesta_selling_code_price.column.SPECIAL')],'index_price_key2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('const_db_tostem.db.giesta_selling_code_price.nametable'));
    }
}
