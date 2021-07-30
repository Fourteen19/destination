<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArticleToEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->foreignId('article_id')->nullable()->after('website');

            $table->foreign('article_id')
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

        Schema::table('employers', function (Blueprint $table) {
            $table->dropForeign(['article_id']);
            $table->dropColumn(['article_id']);
        });

    }
}
