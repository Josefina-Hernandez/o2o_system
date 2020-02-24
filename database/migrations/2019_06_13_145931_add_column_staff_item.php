<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStaffItem extends Migration
{
    /**
     * Run the migrations.
     * スタッフ趣味、資格、代表施工事例追加
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('staffs', function (Blueprint $table) {
            $table->text('certificate')->nullable()->change();
            $table->text('hobby')->nullable()->change();
            $table->text('case')->nullable()->after("hobby");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('staffs', function (Blueprint $table) {
            $table->string('certificate')->change();
            $table->string('hobby')->change();
            $table->dropColumn('case');
        });
    }
}
