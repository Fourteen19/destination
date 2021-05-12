<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderToRelatedActivityQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('related_activity_questions', function (Blueprint $table) {
            $table->unsignedTinyInteger('order_id')->after('text')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('related_activity_questions', function (Blueprint $table) {
            $table->dropColumn(['order_id']);
        });
    }
}
