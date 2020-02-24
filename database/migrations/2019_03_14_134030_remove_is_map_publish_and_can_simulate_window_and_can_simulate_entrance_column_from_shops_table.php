<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveIsMapPublishAndCanSimulateWindowAndCanSimulateEntranceColumnFromShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'is_map_publish',
                'can_simulate_window',
                'can_simulate_entrance'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->tinyInteger('is_map_publish')->default(0);
            $table->tinyInteger('can_simulate_window')->default(0);
            $table->tinyInteger('can_simulate_entrance')->default(0);
        });
    }
}
