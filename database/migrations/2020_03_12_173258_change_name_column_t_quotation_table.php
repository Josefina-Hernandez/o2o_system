<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnTQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->renameColumn('no', 't_quotation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.t_quotation.nametable'), function (Blueprint $table) {
            $table->renameColumn('t_quotation_id', 'no');
        });
    }
}
