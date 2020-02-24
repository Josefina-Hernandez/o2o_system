<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyZipColumnsShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('zip1')->default('000');
            $table->string('zip2')->default('0000');
            $table->dropColumn('zip');
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
            $table->string('zip')->default('000-0000');
            $table->dropColumn([
                'zip1',
                'zip2'
            ]);
        });
    }
}
