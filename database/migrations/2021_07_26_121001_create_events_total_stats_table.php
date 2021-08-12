<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTotalStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_total_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('client_id');
            $table->foreignId('institution_id');
            $table->foreignId('year_id');
            $table->unsignedInteger('total')->nullable()->default(0);
            $table->unsignedInteger('year_7')->nullable()->default(0);
            $table->unsignedInteger('year_8')->nullable()->default(0);
            $table->unsignedInteger('year_9')->nullable()->default(0);
            $table->unsignedInteger('year_10')->nullable()->default(0);
            $table->unsignedInteger('year_11')->nullable()->default(0);
            $table->unsignedInteger('year_12')->nullable()->default(0);
            $table->unsignedInteger('year_13')->nullable()->default(0);
            $table->unsignedInteger('year_14')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('restrict');

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('restrict');

            $table->foreign('institution_id')
                ->references('id')
                ->on('institutions')
                ->onDelete('restrict');

            $table->foreign('year_id')
                ->references('id')
                ->on('years')
                ->onDelete('restrict');

            $table->index(['client_id', 'event_id', 'institution_id', 'year_id'], 'events_total_stats_client_institution_year_index');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_total_stats');
    }
}
