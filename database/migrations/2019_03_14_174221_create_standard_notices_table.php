<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_notices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->date('published_at');
            $table->string('text');

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
        Schema::dropIfExists('standard_notices');
    }
}
