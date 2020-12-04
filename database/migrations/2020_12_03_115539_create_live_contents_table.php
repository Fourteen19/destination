<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents_live', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title', 255)->nullable();
            $table->string('slug')->nullable();

            $table->morphs('contentable');

            $table->foreignId('template_id');
            $table->foreignId('client_id')->nullable(); //can be null if content is for all clients
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            $table->foreign('template_id')
                    ->references('id')
                    ->on('content_templates')
                    ->onDelete('restrict');

            $table->index(['slug', 'client_id']);

        });


        Schema::create('content_articles_live', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->enum('type', ['article', 'employer_profile'])->default('article');
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->text('statement')->nullable();
            $table->text('alt_block_heading')->nullable();
            $table->text('alt_block_text')->nullable();
            $table->timestamps();
        });


        Schema::create('content_accordion_live', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['article', 'employer_profile'])->default('article');
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('content_accordion_live');

        Schema::dropIfExists('content_articles_live');

        Schema::table('contents_live', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['template_id']);
            $table->dropIndex(['slug', 'client_id']);
        });

        Schema::dropIfExists('contents_live');

    }
}
