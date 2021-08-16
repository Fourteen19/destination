<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArticlesTotalStatsIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles_total_stats', function (Blueprint $table) {
            $table->foreignId('institution_id')->nullable()->after('client_id');
            $table->foreignId('year_id')->nullable()->after('institution_id');

            $table->dropForeign(['client_id']);
            $table->dropForeign(['content_id']);
            $table->dropIndex(['client_id', 'content_id']);


            $table->foreign('content_id')
                    ->references('id')
                    ->on('contents')
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

            $table->index(['client_id', 'content_id', 'institution_id', 'year_id'], 'articles_total_stats_client_content_institution_year_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles_total_stats', function (Blueprint $table) {

            //removes foreign keys
            $table->dropForeign(['client_id']);
            $table->dropForeign(['content_id']);
            $table->dropForeign(['institution_id']);
            $table->dropForeign(['year_id']);
            //removes index
            $table->dropIndex(['client_id', 'content_id', 'institution_id', 'year_id']);
            //removes column
            $table->dropColumn(['institution_id', 'year_id']);


            //re-adds foreign keys
            $table->foreign('content_id')
                    ->references('id')
                    ->on('contents')
                    ->onDelete('restrict');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            //re-adds index
            $table->index(['client_id', 'content_id']);
        });
    }
}