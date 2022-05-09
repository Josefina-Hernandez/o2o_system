<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddColumnGiestaPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.giesta_selling_code_price.nametable'), function (Blueprint $table) {
             
            $table->string(config('const_db_tostem.db.giesta_selling_code_price.column.MATERIAL'), 50)->nullable();
            $table->string(config('const_db_tostem.db.giesta_selling_code_price.column.GLASS_TYPE'), 50)->nullable();
            $table->string(config('const_db_tostem.db.giesta_selling_code_price.column.GLASS_THICKNESS'), 50)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.giesta_selling_code_price.nametable'), function (Blueprint $table) {
             
            $table->dropColumn(config('const_db_tostem.db.giesta_selling_code_price.column.MATERIAL'), 50)->nullable();
            $table->dropColumn(config('const_db_tostem.db.giesta_selling_code_price.column.GLASS_TYPE'), 50)->nullable();
            $table->dropColumn(config('const_db_tostem.db.giesta_selling_code_price.column.GLASS_THICKNESS'), 50)->nullable();
            
        });
    }
}
