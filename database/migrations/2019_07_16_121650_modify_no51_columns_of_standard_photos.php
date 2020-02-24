<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyNo51ColumnsOfStandardPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standard_photos', function (Blueprint $table) {
            $table->dropColumn('purpose');
            $table->text('reason');
            $table->tinyInteger('built_year');
            $table->text('category_for_search');
            $table->tinyInteger('client_age')->nullable();
            $table->tinyInteger('household')->nullable();
            $table->tinyInteger('child')->nullable();
            $table->text('pet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('standard_photos', function (Blueprint $table) {
            $table->text('purpose');
            $table->dropColumn([
                'reason',
                'built_year',
                'category_for_search',
                'client_age',
                'household',
                'child',
                'pet',
            ]);
        });
    }
}
