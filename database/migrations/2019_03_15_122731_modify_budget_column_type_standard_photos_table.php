<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBudgetColumnTypeStandardPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standard_photos', function (Blueprint $table) {
            $table->smallInteger('budget')->nullable()->change();
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
            $table->smallInteger('budget')->nullable(false)->change();
        });
    }
}
