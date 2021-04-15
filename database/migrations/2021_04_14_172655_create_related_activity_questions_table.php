<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedActivityQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_activity_questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->text('text')->nullable();
            $table->morphs('activquestionable', 'activ_questionable_index'); //second parameter is a cusom index name as the default one was too long
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
        Schema::dropIfExists('related_activity_questions');
    }
}
