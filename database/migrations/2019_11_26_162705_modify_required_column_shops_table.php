<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyRequiredColumnShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('shops', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['pref_id']);
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->string('normally_close_day')->nullable()->change();
            $table->string('street')->nullable()->change();
            $table->integer('city_id')->nullable()->change();
            $table->integer('pref_id')->nullable()->change();
            $table->string('company_name_kana')->nullable()->change();
            $table->string('kana')->nullable()->change();
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
            $table->string('normally_close_day')->change();
            $table->string('street')->change();
            $table->integer('city_id')->unsigned()->change();
            $table->integer('pref_id')->unsigned()->change();
            $table->string('company_name_kana')->change();
            $table->string('kana')->change();
            $table->foreign('pref_id')->references('id')->on('prefs');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }
}
