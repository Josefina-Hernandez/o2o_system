<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->string('company_name');
            $table->string('company_name_kana');
            $table->string('kana');
            $table->string('president_name')->nullable()->default(null);
            $table->string('personnel_name')->nullable()->default(null);
            $table->string('zip')->default('0000000');
            $table->integer('pref_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('street');
            $table->string('building')->nullable()->default(null);
            $table->decimal('latitude', 9, 6)->nullable()->default(null);
            $table->decimal('longitude', 9, 6)->nullable()->default(null);
            $table->tinyInteger('is_map_publish')->default(0);
            $table->string('support_area')->nullable()->default(null);
            $table->string('tel')->default('000-0000-0000');
            $table->string('fax')->default('000-0000-0000');
            $table->string('email');
            $table->time('open_time');
            $table->time('close_time');
            $table->string('other_time')->nullable()->default(null);
            $table->string('normally_close_day');
            $table->text('support_detail');
            $table->text('certificate');
            $table->string('site_url')->nullable()->default(null);
            $table->string('capital')->nullable()->default(null);
            $table->string('company_start')->nullable()->default(null);
            $table->text('company_history')->nullable()->default(null);
            $table->string('license')->nullable()->default(null);
            $table->integer('employee_number')->nullable()->default(null);
            $table->text('message')->nullable()->default(null);
            $table->tinyInteger('has_t_point')->default(0);
            $table->tinyInteger('is_no_rate')->default(0);
            $table->tinyInteger('can_pay_by_credit_card')->default(0);
            $table->string('twitter')->nullable()->default(null);
            $table->string('facebook')->nullable()->default(null);
            $table->string('shop_code')->default('xxxx');
            $table->string('premium_shop_domain')->nullable()->default(null);
            $table->tinyInteger('can_simulate_window')->default(0);
            $table->tinyInteger('can_simulate_entrance')->default(0);
            $table->tinyInteger('standard_shop_publish_status')->default(1);
            $table->tinyInteger('is_published_premium')->default(1);
            
            // 外部キー
            $table->foreign('pref_id')->references('id')->on('prefs');
            $table->foreign('city_id')->references('id')->on('cities');
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
            $table->dropColumn([
                'company_name',
                'company_name_kana',
                'kana',
                'president_name',
                'personnel_name',
                'zip',
                'pref_id',
                'city_id',
                'street',
                'building',
                'latitude',
                'longitude',
                'is_map_publish',
                'support_area',
                'tel',
                'fax',
                'email',
                'open_time',
                'close_time',
                'other_time',
                'normally_close_day',
                'support_detail',
                'certificate',
                'site_url',
                'capital',
                'company_start',
                'company_history',
                'license',
                'employee_number',
                'message',
                'has_t_point',
                'is_no_rate',
                'can_pay_by_credit_card',
                'twitter',
                'facebook',
                'shop_code',
                'premium_shop_domain',
                'can_simulate_window',
                'can_simulate_entrance',
                'standard_shop_publish_status',
                'is_published_premium',
            ]);
        });
    }
}
