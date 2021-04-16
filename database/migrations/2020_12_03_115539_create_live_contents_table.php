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
            $table->unsignedInteger('word_count')->default(0);
            $table->enum('summary_image_type', ['Automatic', 'Custom'])->default('Automatic');
            $table->string('summary_heading', 255)->nullable();
            $table->text('summary_text')->nullable();

            $table->morphs('contentable');

            $table->foreignId('template_id');
            $table->foreignId('client_id')->nullable(); //can be null if content is for all clients
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

            $table->foreign('updated_by')
                    ->references('id')
                    ->on('admins')
                    ->onDelete('restrict');

            $table->foreign('template_id')
                    ->references('id')
                    ->on('content_templates')
                    ->onDelete('restrict');

            $table->index(['slug', 'client_id']);

            $table->softDeletes();

        });


        Schema::create('content_articles_live', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            //$table->enum('type', ['article', 'employer_profile'])->default('article');
            $table->string('subheading', 255)->nullable();
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->text('lower_body')->nullable();
            $table->text('alt_block_heading')->nullable();
            $table->text('alt_block_text')->nullable();
            $table->timestamps();
        });


        Schema::create('content_accordions_live', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            //$table->enum('type', ['article', 'employer_profile'])->default('article');
            $table->string('subheading', 255)->nullable();
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

        Schema::dropIfExists('content_accordions_live');

        Schema::dropIfExists('content_articles_live');

        Schema::table('contents_live', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['template_id']);
            $table->dropForeign(['updated_by']);
            $table->dropIndex(['slug', 'client_id']);
        });

        Schema::dropIfExists('contents_live');

    }
}
