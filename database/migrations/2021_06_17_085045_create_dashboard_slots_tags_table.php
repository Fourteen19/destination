<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardSlotsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboards_slots_tags', function (Blueprint $table) {
            $table->foreignId('dashboard_id');
            $table->unsignedTinyInteger('slot_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->primary(['dashboard_id', 'slot_id', 'tag_id']);

            $table->foreign('dashboard_id')->references('id')->on('dashboards')->onDelete('Restrict');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('Restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboards_slots_tags');
    }
}
