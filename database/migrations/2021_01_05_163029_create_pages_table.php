<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('page_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('show', ['Y', 'N'])->default('N');
            $table->string('slug')->nullable();
            $table->string('slug_plural')->nullable();
            $table->timestamps();
        });


        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title', 255)->nullable();
            $table->string('slug')->nullable();
            $table->enum('displayInHeader', ['Y','N'])->default('N');
            $table->integer('order_id')->nullable();

            $table->morphs('pageable');

            $table->foreignId('template_id')->nullable();
            $table->foreignId('client_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['slug', 'client_id']);

            $table->foreign('template_id')
                    ->references('id')
                    ->on('page_templates')
                    ->onDelete('restrict');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');
        });


        Schema::create('pages_live', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title', 255)->nullable();
            $table->string('slug')->nullable();
            $table->enum('displayInHeader', ['Y','N'])->default('N');
            $table->integer('order_id')->nullable();

            $table->morphs('pageable');

            $table->foreignId('template_id');
            $table->foreignId('client_id')->nullable(); //can be null if content is for all clients

            $table->timestamps();
            $table->softDeletes();

            $table->index(['slug', 'client_id']);

            $table->foreign('template_id')
                    ->references('id')
                    ->on('page_templates')
                    ->onDelete('restrict');

            $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('restrict');

        });


        Schema::create('page_homepage', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('banner_title', 255)->nullable();
            $table->text('banner_text')->nullable();
            $table->string('link1_text', 255)->nullable();
            $table->foreignId('link1_page_id')->nullable();
            $table->string('link2_text', 255)->nullable();
            $table->foreignId('link2_page_id')->nullable();
            $table->string('free_articles_block_heading', 255)->nullable();
            $table->string('free_articles_block_text', 255)->nullable();
            $table->foreignId('free_articles_slot1_page_id')->nullable();
            $table->foreignId('free_articles_slot2_page_id')->nullable();
            $table->foreignId('free_articles_slot3_page_id')->nullable();
            $table->timestamps();

            $table->foreign('link1_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

            $table->foreign('link2_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot1_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot2_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot3_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

        });


        Schema::create('page_standard', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('lead', 255)->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });


        Schema::create('page_homepage_live', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('banner_title', 255)->nullable();
            $table->text('banner_text')->nullable();
            $table->string('link1_text', 255)->nullable();
            $table->foreignId('link1_page_id')->nullable();
            $table->string('link2_text', 255)->nullable();
            $table->foreignId('link2_page_id')->nullable();
            $table->string('free_articles_block_heading', 255)->nullable();
            $table->string('free_articles_block_text', 255)->nullable();
            $table->foreignId('free_articles_slot1_page_id')->nullable();
            $table->foreignId('free_articles_slot2_page_id')->nullable();
            $table->foreignId('free_articles_slot3_page_id')->nullable();
            $table->timestamps();

            $table->foreign('link1_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

            $table->foreign('link2_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot1_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot2_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

            $table->foreign('free_articles_slot3_page_id')
                ->references('id')
                ->on('pages_live')
                ->onDelete('SET NULL');

        });


        Schema::create('page_standard_live', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('lead', 255)->nullable();
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
        Schema::dropIfExists('page_standard_live');
        Schema::dropIfExists('page_homepage_live');
        Schema::dropIfExists('page_standard');
        Schema::dropIfExists('page_homepage');
        Schema::dropIfExists('pages_live');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_templates');
    }
}
