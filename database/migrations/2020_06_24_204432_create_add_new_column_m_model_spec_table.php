<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddNewColumnMModelSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_model_spec', function (Blueprint $table) {
             
            $table->string('spec32', 100)->nullable();
            $table->string('spec33', 100)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('m_model_spec', function (Blueprint $table) {
             
            $table->dropColumn('spec32');
            $table->dropColumn('spec33');

        });
    }
}
