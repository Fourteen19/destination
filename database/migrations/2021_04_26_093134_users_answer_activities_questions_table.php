<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersAnswerActivitiesQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_activity_question_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('related_question_id')->unsigned();
            $table->text('answer')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('related_question_id')->references('id')->on('related_activity_questions');

            $table->unique(['user_id', 'related_question_id'], 'activity_question_user_id__unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_activity_question_user');
    }
}
