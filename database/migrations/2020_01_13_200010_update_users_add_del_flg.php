<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersAddDelFlg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->nullable();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('phonenumber')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('admin')->default('0');
            $table->tinyInteger('del_flg')->default('0');
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
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
            $table->dropColumn('del_flg');

            $table->dropColumn('email');
            $table->dropColumn('name');
            $table->dropColumn('company');
            $table->dropColumn('phonenumber');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
            $table->dropColumn('status');
            $table->dropColumn('admin');
            $table->dropColumn('del_flg');
            $table->dropColumn('create_user');
            $table->dropColumn('update_user');
        });
    }
}
