<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDataConvertUpdateDataGiestaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
         
         
        Schema::create('t_data_convert_update_data_giesta', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('spec51')->nullable();
                    $table->string('spec51_name')->nullable();
                    $table->string('spec53')->nullable();
                    $table->string('spec53_name')->nullable();
                    $table->string('spec56')->nullable();
                    $table->string('spec56_name')->nullable();
                    $table->string('d_except')->nullable();
                    $table->string('d_size')->nullable();
                    $table->string('d_before')->nullable();
                    $table->string('d_after')->nullable();
                    $table->integer('flg_action')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_data_convert_update_data_giesta');
    }
}
