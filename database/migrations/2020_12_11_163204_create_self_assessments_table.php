<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelfAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->unsignedTinyInteger('year')->default(7);
            $table->float('career_readiness_average', 2, 2)->default(0);
            $table->unsignedTinyInteger('career_readiness_score_1')->default(0);
            $table->unsignedTinyInteger('career_readiness_score_2')->default(0);
            $table->unsignedTinyInteger('career_readiness_score_3')->default(0);
            $table->unsignedTinyInteger('career_readiness_score_4')->default(0);
            $table->unsignedTinyInteger('career_readiness_score_5')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users');

            $table->index(['user_id', 'year']);

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('self_assessments');
    }
}
