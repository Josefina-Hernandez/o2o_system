<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsCustomerPublishColumnsToPremiumPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('premium_photos', function (Blueprint $table) {
            $table->dropColumn([
                'text',
                'article_id',
                'article_url'
            ]);
            $table->text('summary');
            $table->tinyInteger('is_customer_publish')->default(0);
            $table->integer('wp_article_id')->unsigned();
            $table->string('wp_article_url');
            $table->text('featured_image_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('premium_photos', function (Blueprint $table) {
            $table->dropColumn([
                'summary',
                'is_customer_publish',
                'wp_article_id',
                'wp_article_url'
            ]);
            $table->string('text');
            $table->integer('article_id')->unsigned();
            $table->string('article_url');
            $table->string('featured_image_url')->nullable()->change();
        });
    }
}
