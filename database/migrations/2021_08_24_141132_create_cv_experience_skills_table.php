<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvExperienceSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_employments_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('cv_id')
                ->references('id')
                ->on('cvs')
                ->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cv_employments_skills');
    }
}
