<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMapFieldToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('map')->change();
        });

        Schema::table('events_live', function (Blueprint $table) {
            $table->text('map')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('map', 255)->change();
        });

        Schema::table('events_live', function (Blueprint $table) {
            $table->string('map', 255)->change();
        });
    }
}
