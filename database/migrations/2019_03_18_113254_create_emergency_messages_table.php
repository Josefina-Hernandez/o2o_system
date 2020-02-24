<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencyMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->tinyInteger('is_publish')->default(0);
            $table->text('text');

            $table->softDeletes();
            $table->timestamps();

            // 外部キー
            $table->foreign('shop_id')->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_messages');
    }
}
