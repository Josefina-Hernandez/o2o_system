<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerText2ColumnToStandardPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standard_photos', function (Blueprint $table) {
            $table->text('customer_text_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('standard_photos', function (Blueprint $table) {
            $table->dropColumn('customer_text_2');
        });
    }
}
