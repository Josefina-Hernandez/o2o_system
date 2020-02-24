<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyConstraint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //===========================m_selling_code==============================
        Schema::table(config('const_db_tostem.db.m_selling_code.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.m_selling_code.column.PRODUCT_ID'))->references(config('const_db_tostem.db.product.column.PRODUCT_ID'))->on(config('const_db_tostem.db.product.nametable'));
        });
        //===========================product_trans==============================
        Schema::table(config('const_db_tostem.db.product_trans.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.product_trans.column.PRODUCT_ID'))->references(config('const_db_tostem.db.product.column.PRODUCT_ID'))->on(config('const_db_tostem.db.product.nametable'));
            $table->foreign(config('const_db_tostem.db.product_trans.column.M_LANG_ID'))->references(config('const_db_tostem.db.m_lang.column.M_LANG_ID'))->on(config('const_db_tostem.db.m_lang.nametable'));
        });
        //===========================check_product_model==============================
        Schema::table(config('const_db_tostem.db.check_product_model.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.check_product_model.column.PRODUCT_ID'))->references(config('const_db_tostem.db.product.column.PRODUCT_ID'))->on(config('const_db_tostem.db.product.nametable'));
            $table->foreign(config('const_db_tostem.db.check_product_model.column.M_LANG_ID'))->references(config('const_db_tostem.db.m_lang.column.M_LANG_ID'))->on(config('const_db_tostem.db.m_lang.nametable'));
            $table->foreign(config('const_db_tostem.db.check_product_model.column.M_MODEL_ID'))->references(config('const_db_tostem.db.m_model.column.M_MODEL_ID'))->on(config('const_db_tostem.db.m_model.nametable'));
        });
        //===========================m_model_trans==============================
        Schema::table(config('const_db_tostem.db.m_model_trans.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.m_model_trans.column.PRODUCT_ID'))->references(config('const_db_tostem.db.product.column.PRODUCT_ID'))->on(config('const_db_tostem.db.product.nametable'));
            $table->foreign(config('const_db_tostem.db.m_model_trans.column.M_LANG_ID'))->references(config('const_db_tostem.db.m_lang.column.M_LANG_ID'))->on(config('const_db_tostem.db.m_lang.nametable'));
            $table->foreign(config('const_db_tostem.db.m_model_trans.column.M_MODEL_ID'))->references(config('const_db_tostem.db.m_model.column.M_MODEL_ID'))->on(config('const_db_tostem.db.m_model.nametable'));
        });
        //===========================m_model_spec==============================
        Schema::table(config('const_db_tostem.db.m_model_spec.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.m_model_spec.column.PRODUCT_ID'))->references(config('const_db_tostem.db.product.column.PRODUCT_ID'))->on(config('const_db_tostem.db.product.nametable'));
            $table->foreign(config('const_db_tostem.db.m_model_spec.column.M_MODEL_ID'))->references(config('const_db_tostem.db.m_model.column.M_MODEL_ID'))->on(config('const_db_tostem.db.m_model.nametable'));
        });
        //===========================ctg_trans==============================
        Schema::table(config('const_db_tostem.db.ctg_trans.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.ctg_trans.column.CTG_ID'))->references(config('const_db_tostem.db.ctg.column.CTG_ID'))->on(config('const_db_tostem.db.ctg.nametable'));
            $table->foreign(config('const_db_tostem.db.ctg_trans.column.M_LANG_ID'))->references(config('const_db_tostem.db.m_lang.column.M_LANG_ID'))->on(config('const_db_tostem.db.m_lang.nametable'));
        });
        //===========================product==============================
        Schema::table(config('const_db_tostem.db.product.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.product.column.CTG_PROD_ID'))->references(config('const_db_tostem.db.ctg.column.CTG_ID'))->on(config('const_db_tostem.db.ctg.nametable'));
            $table->foreign(config('const_db_tostem.db.product.column.CTG_RISE_ID'))->references(config('const_db_tostem.db.ctg.column.CTG_ID'))->on(config('const_db_tostem.db.ctg.nametable'));
        });
        //===========================ctg==============================
        Schema::table(config('const_db_tostem.db.ctg.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.ctg.column.PARENT_CTG_ID'))->references(config('const_db_tostem.db.ctg.column.CTG_ID'))->on(config('const_db_tostem.db.ctg.nametable'));
        });
        //===========================m_model==============================
        Schema::table(config('const_db_tostem.db.m_model.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.m_model.column.CTG_MODEL_ID'))->references(config('const_db_tostem.db.ctg.column.CTG_ID'))->on(config('const_db_tostem.db.ctg.nametable'));
        });
        //===========================m_color_ctg_prod==============================
        Schema::table(config('const_db_tostem.db.m_color_ctg_prod.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.m_color_ctg_prod.column.M_COLOR_ID'))->references(config('const_db_tostem.db.m_color.column.M_COLOR_ID'))->on(config('const_db_tostem.db.m_color.nametable'));
            $table->foreign(config('const_db_tostem.db.m_color_ctg_prod.column.CTG_PROD_ID'))->references(config('const_db_tostem.db.ctg.column.CTG_ID'))->on(config('const_db_tostem.db.ctg.nametable'));
        });
        //===========================m_color_trans==============================
        Schema::table(config('const_db_tostem.db.m_color_trans.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.m_color_trans.column.M_COLOR_ID'))->references(config('const_db_tostem.db.m_color.column.M_COLOR_ID'))->on(config('const_db_tostem.db.m_color.nametable'));
            $table->foreign(config('const_db_tostem.db.m_color_trans.column.M_LANG_ID'))->references(config('const_db_tostem.db.m_lang.column.M_LANG_ID'))->on(config('const_db_tostem.db.m_lang.nametable'));
        });
        //===========================m_color_model==============================
        Schema::table(config('const_db_tostem.db.m_color_model.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.m_color_model.column.M_COLOR_ID'))->references(config('const_db_tostem.db.m_color.column.M_COLOR_ID'))->on(config('const_db_tostem.db.m_color.nametable'));
            $table->foreign(config('const_db_tostem.db.m_color_model.column.M_MODEL_ID'))->references(config('const_db_tostem.db.m_model.column.M_MODEL_ID'))->on(config('const_db_tostem.db.m_model.nametable'));
        });
        //===========================m_selling_spec_trans==============================
        Schema::table(config('const_db_tostem.db.m_selling_spec_trans.nametable'), function (Blueprint $table) {
            $table->foreign(config('const_db_tostem.db.m_selling_spec_trans.column.M_LANG_ID'))->references(config('const_db_tostem.db.m_lang.column.M_LANG_ID'))->on(config('const_db_tostem.db.m_lang.nametable'));
            $table->foreign(config('const_db_tostem.db.m_selling_spec_trans.column.SPEC_CODE'))->references(config('const_db_tostem.db.m_selling_spec.column.SPEC_CODE'))->on(config('const_db_tostem.db.m_selling_spec.nametable'));
        });
        //===========================m_model_spec==============================
        Schema::table(config('const_db_tostem.db.m_model_spec.nametable'), function (Blueprint $table) {
            for($i = 1; $i<=12; $i++)
            {
                $table->foreign(config('const_db_tostem.db.m_model_spec.column.SPEC').$i)->references(config('const_db_tostem.db.m_selling_spec.column.SPEC_CODE'))->on(config('const_db_tostem.db.m_selling_spec.nametable'));
            }
        });
        //===========================m_selling_code==============================
        Schema::table(config('const_db_tostem.db.m_selling_code.nametable'), function (Blueprint $table) {
            for($i = 1; $i<=50; $i++)
            {
                $table->foreign(config('const_db_tostem.db.m_selling_code.column.OPTION').$i)->references(config('const_db_tostem.db.m_selling_spec.column.SPEC_CODE'))->on(config('const_db_tostem.db.m_selling_spec.nametable'));
            }
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('const_db_tostem.db.m_selling_code.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.m_selling_code.column.PRODUCT_ID')]);
        });
        Schema::table(config('const_db_tostem.db.product_trans.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.product_trans.column.PRODUCT_ID')]);
            $table->dropForeign(['m_lang_id']);
        });
        Schema::table(config('const_db_tostem.db.check_product_model.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.check_product_model.column.PRODUCT_ID')]);
            $table->dropForeign([config('const_db_tostem.db.check_product_model.column.M_MODEL_ID')]);
            $table->dropForeign([config('const_db_tostem.db.check_product_model.column.M_LANG_ID')]);
        });
        Schema::table(config('const_db_tostem.db.m_model_trans.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.m_model_trans.column.PRODUCT_ID')]);
            $table->dropForeign([config('const_db_tostem.db.m_model_trans.column.M_LANG_ID')]);
            $table->dropForeign([config('const_db_tostem.db.m_model_trans.column.M_MODEL_ID')]);
        });
        Schema::table(config('const_db_tostem.db.m_model_spec.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.m_model_spec.column.M_MODEL_ID')]);
            $table->dropForeign([config('const_db_tostem.db.m_model_spec.column.PRODUCT_ID')]);
        });
        Schema::table(config('const_db_tostem.db.ctg_trans.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.ctg_trans.column.CTG_ID')]);
            $table->dropForeign([config('const_db_tostem.db.ctg_trans.column.M_LANG_ID')]);
        });
        Schema::table(config('const_db_tostem.db.m_color_trans.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.m_color_trans.column.M_COLOR_ID')]);
            $table->dropForeign([config('const_db_tostem.db.m_color_trans.column.M_LANG_ID')]);
        });
        Schema::table(config('const_db_tostem.db.m_color_ctg_prod.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.m_color_ctg_prod.column.M_COLOR_ID')]);
            $table->dropForeign([config('const_db_tostem.db.m_color_ctg_prod.column.CTG_PROD_ID')]);
        });
        Schema::table(config('const_db_tostem.db.m_color_model.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.m_color_model.column.M_COLOR_ID')]);
            $table->dropForeign([config('const_db_tostem.db.m_color_model.column.M_MODEL_ID')]);
        });
        Schema::table(config('const_db_tostem.db.product.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.product.column.CTG_PROD_ID')]);
            $table->dropForeign([config('const_db_tostem.db.product.column.CTG_RISE_ID')]);
        });
        
        Schema::table(config('const_db_tostem.db.m_selling_spec_trans.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.m_selling_spec_trans.column.M_LANG_ID')]);
            $table->dropForeign([config('const_db_tostem.db.m_selling_spec_trans.column.SPEC_CODE')]);
        });
        Schema::table(config('const_db_tostem.db.ctg.nametable'), function (Blueprint $table) {
            $table->dropForeign([config('const_db_tostem.db.ctg.column.PARENT_CTG_ID')]);
        });
        Schema::table(config('const_db_tostem.db.m_model_spec.nametable'), function (Blueprint $table) {
            for($i = 1; $i<=12; $i++)
            {
                $table->dropForeign([config('const_db_tostem.db.m_model_spec.column.SPEC').$i]);
            }
        });
        Schema::table(config('const_db_tostem.db.m_selling_code.nametable'), function (Blueprint $table) {
            for($i = 1; $i<=50; $i++)
            {
                $table->dropForeign([config('const_db_tostem.db.m_selling_code.column.OPTION').$i]);
            }
        });
    }
}
