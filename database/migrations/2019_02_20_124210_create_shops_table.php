<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_class_id')->unsigned();
            $table->string('name');

            $table->softDeletes();
            // 継続ログイン（remember me）の仕組みが欲しい時は呼び出しが必要だが、現状不要なのでコメントアウト
            // $table->rememberToken();
            $table->timestamps();
            
            // 外部キー
            $table->foreign('shop_class_id')->references('id')->on('shop_classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
