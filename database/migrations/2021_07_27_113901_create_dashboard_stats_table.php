<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('year_id');

            $table->string('top_article_1', 255)->nullable();
            $table->bigInteger('top_article_1_views')->default(0);
            $table->string('top_article_2', 255)->nullable();
            $table->bigInteger('top_article_2_views')->default(0);
            $table->string('top_article_3', 255)->nullable();
            $table->bigInteger('top_article_3_views')->default(0);
            $table->string('top_article_4', 255)->nullable();
            $table->bigInteger('top_article_4_views')->default(0);
            $table->string('top_article_5', 255)->nullable();
            $table->bigInteger('top_article_5_views')->default(0);
            $table->string('top_article_6', 255)->nullable();
            $table->bigInteger('top_article_6_views')->default(0);
            $table->string('top_article_7', 255)->nullable();
            $table->bigInteger('top_article_7_views')->default(0);
            $table->string('top_article_8', 255)->nullable();
            $table->bigInteger('top_article_8_views')->default(0);
            $table->string('top_article_9', 255)->nullable();
            $table->bigInteger('top_article_9_views')->default(0);
            $table->string('top_article_10', 255)->nullable();
            $table->bigInteger('top_article_10_views')->default(0);

            $table->string('top_institution_1', 255)->nullable();
            $table->bigInteger('top_institution_1_views')->default(0);
            $table->string('top_institution_2', 255)->nullable();
            $table->bigInteger('top_institution_2_views')->default(0);
            $table->string('top_institution_3', 255)->nullable();
            $table->bigInteger('top_institution_3_views')->default(0);
            $table->string('top_institution_4', 255)->nullable();
            $table->bigInteger('top_institution_4_views')->default(0);
            $table->string('top_institution_5', 255)->nullable();
            $table->bigInteger('top_institution_5_views')->default(0);

            $table->bigInteger('logins-1')->nullable()->default(0);
            $table->bigInteger('logins-7')->nullable()->default(0);
            $table->bigInteger('logins-30')->nullable()->default(0);
            $table->bigInteger('logins-academic-year')->nullable()->default(0);

            $table->string('top_vacancy_1', 255)->nullable();
            $table->bigInteger('top_vacancy_1_views')->default(0);
            $table->string('top_vacancy_2', 255)->nullable();
            $table->bigInteger('top_vacancy_2_views')->default(0);
            $table->string('top_vacancy_3', 255)->nullable();
            $table->bigInteger('top_vacancy_3_views')->default(0);
            $table->string('top_vacancy_4', 255)->nullable();
            $table->bigInteger('top_vacancy_4_views')->default(0);
            $table->string('top_vacancy_5', 255)->nullable();
            $table->bigInteger('top_vacancy_5_views')->default(0);

            $table->string('top_event_1', 255)->nullable();
            $table->bigInteger('top_event_1_views')->default(0);
            $table->string('top_event_2', 255)->nullable();
            $table->bigInteger('top_event_2_views')->default(0);
            $table->string('top_event_3', 255)->nullable();
            $table->bigInteger('top_event_3_views')->default(0);
            $table->string('top_event_4', 255)->nullable();
            $table->bigInteger('top_event_4_views')->default(0);
            $table->string('top_event_5', 255)->nullable();
            $table->bigInteger('top_event_5_views')->default(0);

            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('restrict');

            $table->foreign('year_id')
                ->references('id')
                ->on('years')
                ->onDelete('restrict');

            $table->index(['client_id', 'year_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboard_stats');
    }
}
