<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('shop_id')->unsigned();
            $table->integer('shop_class_id')->unsigned();
            $table->string('login_id')->unique();

            $table->softDeletes();
            
            // 外部キー
            $table->foreign('shop_id')->references('id')->on('shops');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('login_id');
            $table->dropColumn('shop_class_id');
            $table->dropColumn('shop_id');
        });
    }
}
