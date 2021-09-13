<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeywordsTagsTotalStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keywords_tags_total_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('institution_id');
            $table->unsignedInteger('tag_id');
            $table->foreignId('year_id');
            $table->unsignedInteger('total')->nullable()->default(0); //nb times read MONTHLY in total for year 7, 8, 9, 10, 11, 12, 13, post
            $table->unsignedInteger('year_7')->nullable()->default(0); //nb times read MONTHLY in total for year 7
            $table->unsignedInteger('year_8')->nullable()->default(0);
            $table->unsignedInteger('year_9')->nullable()->default(0);
            $table->unsignedInteger('year_10')->nullable()->default(0);
            $table->unsignedInteger('year_11')->nullable()->default(0);
            $table->unsignedInteger('year_12')->nullable()->default(0);
            $table->unsignedInteger('year_13')->nullable()->default(0);
            $table->unsignedInteger('year_14')->nullable()->default(0);
            $table->unsignedInteger('post')->nullable()->default(0);
            $table->timestamps();

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
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

            $table->index(['client_id', 'tag_id', 'institution_id', 'year_id'], 'keywords_tags_total_stats_client_tag_institution_year_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keywords_tags_total_stats');
    }
}
