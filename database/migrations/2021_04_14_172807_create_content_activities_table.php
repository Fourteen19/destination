<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('subheading', 255)->nullable();
            $table->text('lead')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();
        });


        Schema::create('content_activities_live', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
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
        Schema::dropIfExists('content_activities');
        Schema::dropIfExists('content_activities_live');
    }
}
