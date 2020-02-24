<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->tinyInteger('rank');
            $table->string('post')->nullable();
            $table->string('name');
            $table->text('message');
            $table->string('certificate')->nullable();
            $table->string('hobby')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // 外部キー
            $table->foreign('shop_id')->references('id')->on('shops');

            // ユニーク制約
            $table->unique(['shop_id', 'rank'], 'shop_rank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
}
