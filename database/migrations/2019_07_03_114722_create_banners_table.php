<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->tinyInteger('rank');
            $table->text('url');

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
        Schema::dropIfExists('banners');
    }
}
