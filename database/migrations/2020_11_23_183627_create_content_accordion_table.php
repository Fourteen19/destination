<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentAccordionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_accordions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->enum('type', ['article', 'employer_profile'])->default('article');
            $table->string('subheading', 255)->nullable();
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->string('summary_heading', 255)->nullable();
            $table->text('summary_text')->nullable();
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
        Schema::dropIfExists('content_accordions');
    }
}
