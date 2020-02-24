<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLatitudeAndLongitudeColumnsShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->decimal('latitude', 9, 6)->nullable(false)->default(0)->change();
            $table->decimal('longitude', 9, 6)->nullable(false)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->decimal('latitude', 9, 6)->nullable()->default(null)->change();
            $table->decimal('longitude', 9, 6)->nullable()->default(null)->change();
        });
    }
}
