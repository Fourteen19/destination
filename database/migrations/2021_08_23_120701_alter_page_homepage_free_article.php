<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPageHomepageFreeArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_homepage', function (Blueprint $table) {

            $table->dropForeign(['free_articles_slot1_page_id']);
            $table->dropForeign(['free_articles_slot2_page_id']);
            $table->dropForeign(['free_articles_slot3_page_id']);

            $table->foreign('free_articles_slot1_page_id')
                ->references('id')
                ->on('contents')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot2_page_id')
                ->references('id')
                ->on('contents')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot3_page_id')
                ->references('id')
                ->on('contents')
                ->onDelete('SET NULL');

        });


        Schema::table('page_homepage_live', function (Blueprint $table) {

            $table->dropForeign(['free_articles_slot1_page_id']);
            $table->dropForeign(['free_articles_slot2_page_id']);
            $table->dropForeign(['free_articles_slot3_page_id']);

            $table->foreign('free_articles_slot1_page_id')
                ->references('id')
                ->on('contents')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot2_page_id')
                ->references('id')
                ->on('contents')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot3_page_id')
                ->references('id')
                ->on('contents')
                ->onDelete('SET NULL');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_homepage', function (Blueprint $table) {

            $table->dropForeign(['free_articles_slot1_page_id']);
            $table->dropForeign(['free_articles_slot2_page_id']);
            $table->dropForeign(['free_articles_slot3_page_id']);

            $table->foreign('free_articles_slot1_page_id')
                ->references('id')
                ->on('contents_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot2_page_id')
                ->references('id')
                ->on('contents_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot3_page_id')
                ->references('id')
                ->on('contents_live')
                ->onDelete('SET NULL');

        });


        Schema::table('page_homepage_live', function (Blueprint $table) {

            $table->dropForeign(['free_articles_slot1_page_id']);
            $table->dropForeign(['free_articles_slot2_page_id']);
            $table->dropForeign(['free_articles_slot3_page_id']);

            $table->foreign('free_articles_slot1_page_id')
                ->references('id')
                ->on('contents_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot2_page_id')
                ->references('id')
                ->on('contents_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot3_page_id')
                ->references('id')
                ->on('contents_live')
                ->onDelete('SET NULL');

        });
    }
}
