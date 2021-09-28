<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsInternalToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('events', function (Blueprint $table) {
            $table->enum('is_internal', ['Y', 'N'])->default('N')->after('map');
        });


        Schema::table('events_live', function (Blueprint $table) {
            $table->enum('is_internal', ['Y', 'N'])->default('N')->after('map');
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
            $table->dropColumn(['is_internal']);
        });

        Schema::table('events_live', function (Blueprint $table) {
            $table->dropColumn(['is_internal']);
        });

    }

}
