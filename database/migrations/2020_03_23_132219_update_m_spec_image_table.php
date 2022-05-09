<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMSpecImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('const_db_tostem.db.m_spec_image.nametable'), function (Blueprint $table) {
            $table->dropColumn(config('const_db_tostem.db.m_spec_image.column.OPTION1'));
            $table->dropColumn(config('const_db_tostem.db.m_spec_image.column.OPTION2'));
            $table->dropColumn(config('const_db_tostem.db.m_spec_image.column.OPTION3'));
            for($i = 1; $i <= 27; $i++)
            {
                $table->dropColumn(config('const_db_tostem.db.m_spec_image.column.SPEC').$i);
            }
            $table->string(config('const_db_tostem.db.m_spec_image.column.SPEC').'51')->nullable()->after(config('const_db_tostem.db.m_spec_image.column.IMG_NAME'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_spec_image.nametable'), function (Blueprint $table) {
            $table->string(config('const_db_tostem.db.m_spec_image.column.OPTION1'))->nullable();
            $table->string(config('const_db_tostem.db.m_spec_image.column.OPTION2'))->nullable();
            $table->string(config('const_db_tostem.db.m_spec_image.column.OPTION3'))->nullable();
            for($i = 1; $i <= 27; $i++)
            {
                $table->string(config('const_db_tostem.db.m_spec_image.column.SPEC').$i)->nullable();
            }
            $table->dropColumn(config('const_db_tostem.db.m_spec_image.column.SPEC').'51');
        });
    }
}
