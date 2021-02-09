<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotedArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flagged_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('article_id');
            $table->enum('high_priority', ['Y','N'])->default('N');

            $table->timestamps();

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            $table->foreign('article_id')
                    ->references('id')
                    ->on('contents_live');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flagged_articles');
    }
}
