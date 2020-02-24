<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMMailaddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_mailaddress', function (Blueprint $table) {
            $table->increments('id');
            $table->text('groupname')->nullable();
            $table->text('description')->nullable();
            $table->text('maillist')->nullable();
            $table->tinyInteger('del_flg')->default('0');
            $table->integer('add_user_id')->nullable();
            $table->timestamp('add_datetime')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('upd_user_id')->nullable();
            $table->timestamp('upd_datetime')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_mailaddress');
    }
}
