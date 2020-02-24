<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->string('title');
            $table->text('summary');
            $table->text('main_text');
            $table->text('before_text');
            $table->text('after_text');
            $table->tinyInteger('is_customer_publish')->default(1);
            $table->text('customer_text')->nullable();
            $table->tinyInteger('category');
            $table->text('parts');
            $table->text('purpose');
            $table->string('locale');
            $table->smallInteger('budget');
            $table->string('period');
            $table->string('product');

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
        Schema::dropIfExists('standard_photos');
    }
}
