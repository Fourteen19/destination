<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cv_employments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id');
            $table->string('organisation', 255)->nullable();
            $table->string('job_role', 255)->nullable();
            $table->enum('job_type', ['employed', 'volunteering', 'work-experience'])->default('employed');
            $table->string('from', 255)->nullable();
            $table->string('to', 255)->nullable();
            $table->enum('tasks_type', ['bullets', 'paragraph'])->default('bullets');
            $table->text('tasks_txt')->nullable();
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
        Schema::dropIfExists('cv_employments');
    }
}
