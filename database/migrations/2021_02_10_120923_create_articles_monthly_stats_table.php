<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesMonthlyStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_monthly_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id');
            $table->foreignId('client_id');
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

            $table->foreign('content_id')
                    ->references('id')
                    ->on('contents')
                    ->onDelete('restrict');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            $table->index(['client_id', 'content_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::dropIfExists('articles_monthly_stats');
    }
}
