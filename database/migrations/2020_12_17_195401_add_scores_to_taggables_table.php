<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoresToTaggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taggables', function (Blueprint $table) {
            $table->unsignedInteger('assessment_answer')->default(0)->after('taggable_id');
            $table->unsignedInteger('score')->default(0)->after('assessment_answer');
            $table->unsignedInteger('total_score')->default(0)->after('score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tagables', function (Blueprint $table) {
            $table->dropColumn(['assessment_answer', 'score', 'total_score']);
        });
    }
}
