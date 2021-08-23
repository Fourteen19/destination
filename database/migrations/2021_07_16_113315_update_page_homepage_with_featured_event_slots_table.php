<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePageHomepageWithFeaturedEventSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_homepage', function (Blueprint $table) {
            $table->foreignId('featured_event_slot1_id')->nullable()->after('free_articles_slot3_page_id');
            $table->foreignId('featured_event_slot2_id')->nullable()->after('featured_event_slot1_id');

            $table->foreign('featured_event_slot1_id')
                    ->references('id')
                    ->on('events_live')
                    ->onDelete('SET NULL');

            $table->foreign('featured_event_slot2_id')
                    ->references('id')
                    ->on('events_live')
                    ->onDelete('SET NULL');
        });


        Schema::table('page_homepage_live', function (Blueprint $table) {
            $table->foreignId('featured_event_slot1_id')->nullable()->after('free_articles_slot3_page_id');
            $table->foreignId('featured_event_slot2_id')->nullable()->after('featured_event_slot1_id');

            $table->foreign('featured_event_slot1_id')
                    ->references('id')
                    ->on('events_live')
                    ->onDelete('SET NULL');

            $table->foreign('featured_event_slot2_id')
                    ->references('id')
                    ->on('events_live')
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
            $table->dropForeign(['featured_event_slot1_id']);
            $table->dropForeign(['featured_event_slot2_id']);
            $table->dropColumn(['featured_event_slot1_id', 'featured_event_slot2_id']);
        });

        Schema::table('page_homepage_live', function (Blueprint $table) {
            $table->dropForeign(['featured_event_slot1_id']);
            $table->dropForeign(['featured_event_slot2_id']);
            $table->dropColumn(['featured_event_slot1_id', 'featured_event_slot2_id']);
        });
    }
}
