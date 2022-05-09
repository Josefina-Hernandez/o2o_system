<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateNametbAndAddColumnTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         
         if (Schema::hasTable(config('const_db_tostem.db.m_door_large_size.nametable'))) {
              
               Schema::rename(config('const_db_tostem.db.m_door_large_size.nametable'), config('const_db_tostem.db.m_door_large_size.nametable_update'));
               
               Schema::table(config('const_db_tostem.db.m_door_large_size.nametable_update'), function (Blueprint $table) {
                       $table->string(config('const_db_tostem.db.m_door_large_size.column.SPEC5'))->nullable();
               });
               //
          }
          

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
               if (Schema::hasTable(config('const_db_tostem.db.m_door_large_size.nametable_update'))) {

                         Schema::rename(config('const_db_tostem.db.m_door_large_size.nametable_update'), config('const_db_tostem.db.m_door_large_size.nametable'));

                         Schema::table(config('const_db_tostem.db.m_door_large_size.nametable_update'), function (Blueprint $table) {
                                $table->dropColumn(config('const_db_tostem.db.m_door_large_size.column.SPEC5'));
                         });
                         //
               }
        
    }
}
