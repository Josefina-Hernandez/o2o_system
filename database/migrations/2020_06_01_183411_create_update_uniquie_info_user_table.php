<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpdateUniquieInfoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->dropUnique('users_login_id_unique');
            $table->unique(['email', 'del_flg', 'deleted_at'], 'users_email_uniques');
            $table->unique(['login_id', 'del_flg', 'deleted_at'], 'users_login_id_uniques');
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
            $table->unique('email', 'users_email_unique');
            $table->unique('login_id', 'users_login_id_unique');
            $table->dropUnique('users_email_uniques');
            $table->dropUnique('users_login_id_uniques');
        });
    }
}
