<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateContentsWithNextArticleToReadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {

            $table->foreignId('read_next_article_id')->nullable()->after('template_id');

            $table->foreign('read_next_article_id')
                    ->references('id')
                    ->on('contents_live')
                    ->onDelete('SET NULL');
        });


        Schema::table('contents_live', function (Blueprint $table) {

            $table->foreignId('read_next_article_id')->nullable()->after('template_id');

            $table->foreign('read_next_article_id')
                    ->references('id')
                    ->on('contents_live')
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
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign(['read_next_article_id']);
        });

        Schema::table('contents_live', function (Blueprint $table) {
            $table->dropForeign(['read_next_article_id']);
        });
    }
}
