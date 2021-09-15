<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvEducationGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_educations_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_education_id');
            $table->string('title', 255)->nullable();
            $table->string('grade', 20)->nullable();
            $table->enum('predicted', ['Y', 'N'])->default('N');
            $table->timestamps();

            $table->foreign('cv_education_id')
                ->references('id')
                ->on('cv_educations')
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
        Schema::dropIfExists('cv_educations_grades');
    }
}
