<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHomepageSettingsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients_articles_settings', function (Blueprint $table) {

            $table->dropForeign(['dashboard_slot_1_id']);
            $table->dropForeign(['dashboard_slot_2_id']);
            $table->dropForeign(['dashboard_slot_3_id']);
            $table->dropForeign(['dashboard_slot_4_id']);
            $table->dropForeign(['dashboard_slot_5_id']);
            $table->dropForeign(['dashboard_slot_6_id']);

            $table->foreign('dashboard_slot_1_id')->references('id')->on('contents')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_2_id')->references('id')->on('contents')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_3_id')->references('id')->on('contents')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_4_id')->references('id')->on('contents')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_5_id')->references('id')->on('contents')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_6_id')->references('id')->on('contents')->onDelete('SET NULL');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients_articles_settings', function (Blueprint $table) {

            $table->dropForeign(['dashboard_slot_1_id']);
            $table->dropForeign(['dashboard_slot_2_id']);
            $table->dropForeign(['dashboard_slot_3_id']);
            $table->dropForeign(['dashboard_slot_4_id']);
            $table->dropForeign(['dashboard_slot_5_id']);
            $table->dropForeign(['dashboard_slot_6_id']);

            $table->foreign('dashboard_slot_1_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_2_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_3_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_4_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_5_id')->references('id')->on('contents_live')->onDelete('SET NULL');
            $table->foreign('dashboard_slot_6_id')->references('id')->on('contents_live')->onDelete('SET NULL');

        });
    }

}
